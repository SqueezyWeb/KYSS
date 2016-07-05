<?php
/**
 * KYSS Role Controller file.
 *
 * @package KYSS\Http\Controllers
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Http\Controllers;

use Illuminate\Http\Request;
use KYSS\Http\Requests\StoreRequest;
use KYSS\Http\Requests\UpdateRequest;

use DB;
use Shinobi;

use KYSS\Models\Role;
use KYSS\Models\User;
use KYSS\Models\Permission;

/**
 * Role Controller.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 0.1.0
 */
class RoleController extends Controller {
  /**
   * Create new instance.
   *
   * @since 0.1.0
   * @access public
   */
  public function __construct() {
    $this->route = 'role';
  }

  /**
   * Display listing of roles.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Request $request
   * @return Response
   */
  public function index(Request $request) {
    if (!Shinobi::can(config('acl.role.index', false)))
      return view('layouts.unauthorized', ['message' => 'view role list']);

    $roles = $this->getData();

    return view('roles.index', compact('roles'));
  }

  /**
   * Return paginated list of roles.
   *
   * Checks if filter is used.
   *
   * @since 0.1.0
   * @access protected
   *
   * @return array Roles
   */
  protected function getData() {
    if (Request::has('q')) {
      $query = Request::get('q');
      $roles = Role::where('name', 'LIKE', sprintf('%%%s%%', $query))
        ->orWhere('slug', 'LIKE', sprintf('%%%s%%', $query))
        ->orWhere('description', 'LIKE', sprintf('%%%s%%', $query))
        ->orderBy('name')->paginate(config('pagination.roles', 20));
      session()->flash('q', $query);
    } else {
      $roles = Role::orderBy('name')->paginate(config('pagination.roles', 20));
      session()->forget('q');
    }

    return $roles;
  }

  /**
   * Display form for creating new Role.
   *
   * @since 0.1.0
   * @access public
   *
   * @return Response
   */
  public function create() {
    if (!Shinobi::can(config('acl.role.create', false)))
      return view('layouts.unauthorized', ['message' => 'create new roles']);

    return view('roles.create')->with('route', $this->route);
  }

  /**
   * Store newly created Role in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param StoreRequest $request
   * @return Response
   */
  public function store(StoreRequest $request) {
    $level = 'danger';
    $message = ' You are not allowed to create roles.';

    if (Shinobi::can(config('acl.role.create', false))) {
      Role::create($request->all());
      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Role created.';
    }

    return redirect()->route('role.index')->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Display specified Role.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Role ID.
   * @return Response
   */
  public function show($id) {
    if (!Shinobi::canAtLeast([
      config('acl.role.edit', false),
      config('acl.role.show', false)
    ]))
      return view('layouts.unauthorized', ['message' => 'view roles']);

    $role = Role::findOrFail($id);
    $route = $this->route;

    return view('roles.show', compact('resource', 'route'));
  }

  /**
   * Display form for editing specified Role.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Role ID.
   * @return Response
   */
  public function edit($id) {
    if (!Shinobi::can(config('acl.role.edit', false)))
      return view('layouts.unauthorized', ['message' => 'edit roles']);

    $role = Role::findOrFail($id);
    $route = $this->route;

    return view('roles.edit', compact('resource', 'route'));
  }

  /**
   * Update specified Role in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Role ID.
   * @param UpdateRequest $request
   * @return Response
   */
  public function update($id, UpdateRequest $request) {
    $level = 'danger';
    $message = ' You are not allowed to update roles.';

    if (Shinobi::can(config('acl.role.edit', false))) {
      $role = Role::findOrFail($id);
      $role->update($request->all());
      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Role edited.';
    }

    return redirect()->route('role.index')->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Remove specified Role from storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Role ID.
   * @return Response
   */
  public function destroy($id) {
    $level = 'danger';
    $message = ' You are not allowed to destoy roles.';

    if (Shinobi::can(config('acl.role.destroy', false))) {
      Role::destroy($id);
      $level = 'warning';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Role deleted.';
    }

    return redirect()->route('role.index')->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Display form for editing role permissions.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Role ID.
   * @return Response
   */
  public function editRolePermissions($id) {
    if (!Shinobi::can(config('acl.role.permissions', false)))
      return view('layouts.unauthorized', ['message' => 'sync role permissions']);

    $role = Role::findOrFail($id);
    $permissions = $role->permissions;
    $available_permissions = Permission::whereDoesntHave('roles', function($query) use ($id) {
      $query->where('role_id', $id);
    })->get();

    return view('roles.permission', compact('role', 'permissions', 'available_permissions'));
  }

  /**
   * Sync roles and permissions.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Role ID.
   * @param Request $request
   * @return Response
   */
  public function updateRolePermissions($id, Request $request) {
    $level = 'danger';
    $message = ' You are not allowed to update role permissions.';

    if (Shinobi::can(config('acl.role.permissions', false))) {
      $role = Role::findOrFail($id);

      if ($request->has('slug'))
        $role->permissions()->sync($request->get('slug'));
      else
        $role->permissions()->detach();

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Role permissions updated.';
    }

    return redirect()->route('role.index')->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Display form for editing role users.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Role ID.
   * @return Response
   */
  public function editRoleUsers($id) {
    if (!Shinobi::can(config('acl.role.users', false)))
      return view('layouts.unauthorized', ['message' => 'sync role users']);

    $role = Role::findOrFail($id);
    $users = $role->users;
    $available_users = User::whereDoesntHave('roles', function($query) use ($id) {
      $query->where('role_id', $id);
    })->get();

    return view('roles.user', compact('role', 'users', 'available_users'));
  }

  /**
   * Sync roles and users.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Role ID.
   * @param Request $request
   * @return Response
   */
  public function updateRoleUsers($id, Request $request) {
    $level = 'danger';
    $message = ' You are not allowed to update role users.';

    if (Shinobi::can(config('acl.role.users', false))) {
      $role = Role::findOrFail($id);

      if ($request->has('slug'))
        $role->users()->sync($request->get('slug'));
      else
        $role->users()->detach();

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Role users updated.';
    }

    return redirect()->route('role.index')->with(['flash' => compact('message', 'level')]);
  }
}
