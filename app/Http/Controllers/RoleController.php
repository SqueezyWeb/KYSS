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

    $roles = $this->getData($request);

    return view('role.index', compact('roles'));
  }

  /**
   * Return paginated list of roles.
   *
   * Checks if filter is used.
   *
   * @since 0.1.0
   * @access protected
   *
   * @param Request $request
   * @return array Roles
   */
  protected function getData(Request $request) {
    if ($request->has('q')) {
      $query = $request->get('q');
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

    return view('role.create');
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
   * @param Role $role Role object.
   * @return Response
   */
  public function show(Role $role) {
    if (!Shinobi::canAtLeast([
      config('acl.role.edit', false),
      config('acl.role.show', false)
    ]))
      return view('layouts.unauthorized', ['message' => 'view roles']);

    $route = $this->route;

    return view('role.show', compact('role', 'route'));
  }

  /**
   * Display form for editing specified Role.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Role $role Role object.
   * @return Response
   */
  public function edit(Role $role) {
    if (!Shinobi::can(config('acl.role.edit', false)))
      return view('layouts.unauthorized', ['message' => 'edit roles']);

    $route = $this->route;

    return view('role.edit', compact('role', 'route'));
  }

  /**
   * Update specified Role in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Role $role Role object.
   * @param UpdateRequest $request
   * @return Response
   */
  public function update(Role $role, UpdateRequest $request) {
    $level = 'danger';
    $message = ' You are not allowed to update roles.';

    if (Shinobi::can(config('acl.role.edit', false))) {
      $role->update($request->all());
      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Role edited.';
    }

    return redirect()->route('role.show', $role->id)->with(['flash' => compact('message', 'level')]);
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
   * @param Role $role Role object.
   * @return Response
   */
  public function editRolePermissions(Role $role) {
    if (!Shinobi::can(config('acl.role.permissions', false)))
      return view('layouts.unauthorized', ['message' => 'sync role permissions']);

    $permissions = $role->permissions;
    $available_permissions = Permission::whereDoesntHave('roles', function($query) use ($role) {
      $query->where('role_id', $role->id);
    })->get();

    return view('role.permissions', compact('role', 'permissions', 'available_permissions'));
  }

  /**
   * Sync roles and permissions.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Role $role Role object.
   * @param Request $request
   * @return Response
   */
  public function updateRolePermissions(Role $role, Request $request) {
    $level = 'danger';
    $message = ' You are not allowed to update role permissions.';

    if (Shinobi::can(config('acl.role.permissions', false))) {
      if ($request->has('permissions'))
        $role->permissions()->sync($request->get('permissions'));
      else
        $role->permissions()->detach();

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Role permissions updated.';
    }

    return redirect()->route('role.show', $role->id)->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Display form for editing role users.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Role $role Role object.
   * @return Response
   */
  public function editRoleUsers(Role $role) {
    if (!Shinobi::can(config('acl.role.users', false)))
      return view('layouts.unauthorized', ['message' => 'sync role users']);

    $users = $role->users;
    $available_users = User::whereDoesntHave('roles', function($query) use ($role) {
      $query->where('role_id', $role->id);
    })->get();

    return view('role.users', compact('role', 'users', 'available_users'));
  }

  /**
   * Sync roles and users.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Role $role Role object.
   * @param Request $request
   * @return Response
   */
  public function updateRoleUsers(Role $role, Request $request) {
    $level = 'danger';
    $message = ' You are not allowed to update role users.';

    if (Shinobi::can(config('acl.role.users', false))) {
      if ($request->has('users'))
        $role->users()->sync($request->get('users'));
      else
        $role->users()->detach();

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Role users updated.';
    }

    return redirect()->route('role.show', $role->id)->with(['flash' => compact('message', 'level')]);
  }
}
