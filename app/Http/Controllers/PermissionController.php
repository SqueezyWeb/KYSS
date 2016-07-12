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
   * @param Request $request HTTP request.
   * @return Response
   */
  public function index(Request $request) {
    if (!Shinobi::can(config('acl.permission.index', false)))
      return view('layouts.unauthorized', ['message' => 'view permission list']);

    $permissions = $this->getData($request);

    return view('permission.index', compact('permissions'));
  }

  /**
   * Return paginated list of items.
   *
   * Additionally checks if filter is used.
   *
   * @since 0.1.0
   * @access protected
   *
   * @param Request $request HTTP request.
   * @return array Permissions
   */
  protected function getData(Request $request) {
    if ($request->has('q')) {
      $query = $request->get('q');
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
   * Display specified Permission.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Permission $permission Permission object.
   * @return Response
   */
  public function show(Permission $permission) {
    if (!Shinobi::canAtLeast([config('acl.permission.show', false), config('acl.permission.edit', false)]))
      return view('layouts.unauthorized', ['message' => 'view permissions']);

    $route = $this->route;

    return view('permission.show', compact('permission'));
  }

  /**
   * Show form for editing permission roles.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Permission $permission Permission object.
   * @return Response
   */
  public function editRoles(Permission $permission) {
    if (!Shinobi::can(config('acl.permission.roles', false)))
      return view('layouts.unauthorized', ['message' => 'sync permission roles']);

    $roles = $permission->roles;
    $available_roles = Role::whereDoesntHave('permissions', function($query) use ($permission) {
      $query->where('permission_id', $permission->id);
    })->get();

    return view('permission.roles', compact('permission', 'roles', 'available_roles'));
  }

  /**
   * Update specified Permission in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Permission $permission Permission object.
   * @return Response
   */
  public function updateRoles(Permission $permission, Request $request) {
    $level = 'danger';
    $message = ' You are not allowed to update permissions.';

    if (Shinobi::can(config('acl.permission.roles', false))) {
      if ($request->has('roles'))
        $permission->roles()->sync($request->get('roles'));
      else
        $permission->roles()->detach();

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! Permission roles edited.';
    }

    return redirect()->route('permission.show', $permission->id)->with(['flash' => compact('message', 'level')]);
  }
}
