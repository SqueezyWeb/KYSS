<?php
/**
 * KYSS User Controller file.
 *
 * @package KYSS\Http\Controllers
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Http\Controllers;

use KYSS\Models\User;
use KYSS\Models\Role;
use KYSS\Http\Requests\UserStoreRequest;
use KYSS\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use DB;
use Shinobi;

/**
 * User Controller.
 *
 * @author Mattia Migliorini <mattia@squeezyweb.com>
 * @since 0.1.0
 * @version 0.1.0
 */
class UserController extends Controller {
  /**
   * Display list of users.
   *
   * @since 0.1.0
   * @access public
   *
   * @param Request $request HTTP request.
   * @return Illuminate\View\View
   */
  public function index(Request $request) {
    // User Unauthorized.
    if (!Shinobi::can(config('acl.user.index', false)))
      return view('layouts.unauthorized', ['message' => 'view user list']);

    // Search
    if ($request->has('q')) {
      $value = $request->get('q');
      // Search name, company, ...?
      $users = User::where('name', 'LIKE', sprintf('%%%s%%', $value))
        ->orderBy('name')->paginate(config('view.pagination.users', 20));
      session()->flash('q', $value);
    } else { // Full listing.
      $users = User::orderBy('name')->paginate(config('view.pagination.users', 20));
      session()->forget('q');
    }

    return view('users.index', compact('users'));
  }

  /**
   * Display form for creating new user.
   *
   * @since 0.1.0
   * @access public
   *
   * @return Illuminate\View\View
   */
  public function create() {
    if (Shinoby::can(config('acl.user.create', false)))
      return view('users.create');
    return view('layouts.unauthorized');
  }

  /**
   * Store newly created user in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @return Response
   */
  public function store(UserStoreRequest $request) {
    $level = 'danger';
    $message = ' You are not allowed to create users.';

    if (Shinoby::can(config('acl.user.create', false))) {
      User::create($request->all());
      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! User created.';
    }

    return redirect()->route('user.index')
      ->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Display specified user.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id Requested User ID.
   * @return Reponse
   */
  public function show($id) {
    if (!Shinoby::canAtLeast([
      config('acl.user.show', false),
      config('acl.user.edit', false)
    ]))
      return view('layouts.unauthorized', ['message' => 'view users']);

    $user = User::findOrFail($id);
    return view('users.show', compact('user'));
  }

  /**
   * Display form for editing specified User.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id User ID.
   * @return Response
   */
  public function edit($id) {
    if (!Shinobi::canAtLeast(config('acl.user.edit', false)))
      return view('layouts.unauthorized', ['message' => 'edit users']);

    $user = User::findOrFail($id);
    return view('users.edit', compact('user'));
  }

  /**
   * Update specified User in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id User ID.
   * @return Response
   */
  public function update($id, UserUpdateRequest $request) {
    $level = 'danger';
    $message = ' You are not permitted to update users.';

    if (Shinobi::can(config('acl.user.edit', false))) {
      $user = User::findOrFail($id);
      if (empty($request->get('password')))
        $user->update($request->except('password'));
      else
        $user->update($request->all());

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! User edited.';
    }

    return redirect()->route('user.index')
      ->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Remove specified user from storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id User ID.
   * @return Response
   */
  public function destroy($id) {
    $level = 'danger';
    $message = ' You are not permitted to destroy user objects.';

    if (Shinobi::can(config('acl.user.destroy', false))) {
      User::destroy($id);
      $level = 'warning';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! User deleted.';
    }

    return redirect()->route('user.index')
      ->with(['flash' => compact('message', 'level')]);
  }

  /**
   * Display form for editing user roles.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id User ID.
   * @return Response
   */
  public function editUserRoles($id) {
    if (!Shinobi::can(config('acl.user.manage', false)))
      return view('layouts.unauthorized', ['message' => 'manage user roles']);

    $user = User::findOrFail($id);
    $roles = $user->roles;

    $available_roles = Role::whereDoesntHave('users', function($query) use ($id) {
      $query->where('user_id', $id);
    })->get();

    return view('users.role', compact('user', 'roles', 'available_roles'));
  }

  /**
   * Update User Roles in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param int $id User ID.
   * @param Request
   * @return Response
   */
  public function updateUserRoles($id, Request $request) {
    $level = 'danger';
    $message = ' You are not permitted to update user roles.';

    if (Shinobi::can(config('acl.user.manage', false))) {
      $user = User::findOrFail($id);

      if ($request->has('roles'))
        $user->roles()->sync($request->get('roles'));
      else
        $user->roles()->detach();

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! User roles edited.';
    }

    return redirect()->route('user.index')
    ->with(['flash' => compact('message', 'level')]);
  }
}
