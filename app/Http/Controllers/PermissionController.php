<?php
/**
 * Permission Controller file.
 *
 * @package KYSS\Http\Controllers
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Http\Controllers;

use Illuminate\Http\Request;
use KYSS\Http\Requests\StoreRequest;
use KYSS\Http\Requests\UpdateRequest;

use Shinobi;

use KYSS\Models\Role;
use KYSS\Models\Permission;

/**
 * Permission Controller.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 0.1.0
 */
class PermissionController extends Controller {
  /**
   * Set resource in contructor.
   *
   * @since 0.1.0
   * @access public
   */
  public function __construct() {
    $this->route = 'permission';
  }

  /**
   * Display listing of permissions.
   *
   * @since 0.1.0
   * @access public
   *
   * @return Response
   */
  public function index() {
    if (!Shinobi::can(config('acl.permission.index', false)))
      return view('layouts.unauthorized', ['message' => 'view permission list']);

    $permissions = $this->getData();

    return view('permissions.index', compact('permissions'));
  }

  /**
   * Return paginated list of items.
   *
   * Additionally checks if filter is used.
   *
   * @since 0.1.0
   * @access protected
   *
   * @return array Permissions
   */
  protected function getData() {
    if (Request::has('q')) {
      $query = Request::get('q');
      $permissions = Permission::where('name', 'LIKE', sprintf('%%%s%%', $query))
        ->orWhere('slug', 'LIKE', sprintf('%%%s%%', $query))
        ->orWhere('description', 'LIKE', sprintf('%%%s%%', $query))
        ->orderBy('name')->paginate(config('pagination.permissions', 20));
      session()->flash('q', $query);
    } else {
      $permissions = Permission::orderBy('name')->paginate(config('pagination.permissions', 20));
      session()->forget('q');
    }

    return $permissions;
  }

  /**
   * Display form for creating new Permission.
   *
   * @since 0.1.0
   * @access public
   *
   * @return Response
   */
  public function create() {
    if (!Shinobi::can(config('acl.permission.create', false)))
      return view('layouts.unauthorized', ['message' => 'create new permissions']);

    return view('permissions.create')->with('route', $this->route);
  }

  /**
   * Store newly created resource in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @return Response
   */
  public function store(StoreRequest $request) {
    $level = 'danger';
    $message = ' You are not allowed to create permissions.';

    if (Shinobi::can(config('acl.permission.create', false))) {
      Permission::create($request->all());
      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Permission created.';
    }

    return redirect()->route('permission.index')->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Display specified Permission.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Permission ID.
   * @return Response
   */
  public function show($id) {
    if (!Shinobi::canAtLeast([config('acl.permission.show', false), config('acl.permission.edit', false)]))
      return view('layouts.unauthorized', ['message' => 'view permissions']);

    $permission = Permission::findOrFail($id);
    $route = $this->route;

    return view('permissions.show', compact('permission', 'route'));
  }

  /**
   * Show form for editing specified Permission.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Permission ID.
   * @return Response
   */
  public function edit($id) {
    if (!Shinobi::canAtLeast([
      config('acl.permission.edit', false),
      config('acl.permission.show', false)
    ]))
      return view('layouts.unauthorized', ['message' => 'edit permissions']);

    $permission = Permission::findOrFail($id);
    $route = $this->route;

    return view('permissions.edit', compact('permission', 'route'));
  }

  /**
   * Update specified Permission in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Permission ID.
   * @return Response
   */
  public function update($id, UpdateRequest $request) {
    $level = 'danger';
    $message = ' You are not allowed to update permissions.';

    if (Shinobi::can(config('acl.permission.edit', false))) {
      $permission = Permission::findOrFail($id);
      $permission->update($request->all());
      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Permission edited.';
    }

    return redirect()->route('permission.index')->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Remove specified Permission from storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Permission ID.
   * @return Response
   */
  public function destroy($id) {
    $level = 'danger';
    $message = ' You are not allowed to destroy permissions.';

    if (Shinobi::can(config('acl.permission.destroy', false))) {
      Permission::destroy($id);
      $level = 'warning';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Permission deleted.';
    }

    return redirect()->route('permission.index')->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Show form for editing permission roles.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Permission ID.
   * @return Response
   */
  public function editRole($id) {
    if (!Shinobi::can(config('acl.permission.role', false)))
      return view('layouts.unauthorized', ['message' => 'sync permission roles']);

    $permission = Permission::findOrFail($id);
    $roles = $permission->roles;
    $available_roles = Role::whereDoesntHave('permissions', function($query) use ($id) {
      $query->where('permission_id', $id);
    })->get();

    return view('permissions.role', compact('permission', 'roles', 'available_roles'));
  }

  /**
   * Update specified Permission in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Permission ID.
   * @return Response
   */
  public function updateRole($id, Request $request) {
    $level = 'danger';
    $message = ' You are not allowed to update permissions.';

    if (Shinobi::can(config('acl.permission.role', false))) {
      $permission = Permission::findOrFail($id);

      if ($request->has('slug'))
        $permission->roles()->sync($request->get('slug'));
      else
        $permission->roles()->sync($request->get('slug'));

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Permission roles edited.';
    }

    return redirect()->route('permission.index')->with(['flash' => compact('message', 'level')]);
  }
}
