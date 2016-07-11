<?php
/**
 * KYSS User Controller file.
 *
 * @package KYSS\Http\Controllers
 * @copyright 2016 SqueezyWeb
 * @since 0.1.0
 */

namespace KYSS\Http\Controllers;

use Illuminate\Http\Request;
use KYSS\Http\Requests\UserStoreRequest;
use KYSS\Http\Requests\UserUpdateRequest;

use KYSS\Models\User;
use KYSS\Models\Role;

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
      $query = $request->get('q');
      // Search name, company, ...?
      $users = User::where('name', 'LIKE', sprintf('%%%s%%', $query))
        ->orWhere('email', 'LIKE', sprintf('%%%s%%', $query))
        ->orderBy('name')->paginate(config('view.pagination.users', 20));
      session()->flash('q', $query);
    } else { // Full listing.
      $users = User::orderBy('name')->paginate(config('view.pagination.users', 20));
      session()->forget('q');
    }

    return view('user.index', compact('users'));
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
    if (Shinobi::can(config('acl.user.create', false)))
      return view('user.create');
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

    if (Shinobi::can(config('acl.user.create', false))) {
      $data = empty($request->get('password')) ? $request->all() : array_add($request->except('password'), 'password', bcrypt($request->get('password')));

      User::create($data);
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
   * @param User $user Requested User object.
   * @return Reponse
   */
  public function show(User $user) {
    if (!Shinobi::canAtLeast([
      config('acl.user.show', false),
      config('acl.user.edit', false)
    ]))
      return view('layouts.unauthorized', ['message' => 'view users']);

    return view('user.show', compact('user'));
  }

  /**
   * Display form for editing specified User.
   *
   * @since 0.1.0
   * @access public
   *
   * @param User $user Requested User object.
   * @return Response
   */
  public function edit(User $user) {
    if (!Shinobi::can(config('acl.user.edit', false)))
      return view('layouts.unauthorized', ['message' => 'edit users']);

    return view('user.edit', compact('user'));
  }

  /**
   * Update specified User in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param User $user User object.
   * @return Response
   */
  public function update(User $user, UserUpdateRequest $request) {
    $level = 'danger';
    $message = ' You are not permitted to update users.';

    if (Shinobi::can(config('acl.user.edit', false))) {
      $data = $request->except('password');
      if (!empty($request->get('password')))
        $data['password'] = bcrypt($request->get('password'));

      $user->update($data);

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! User edited.';
    }

    return redirect()->route('user.show', $user->id)
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
   * @param User $user User object.
   * @return Response
   */
  public function editUserRoles(User $user) {
    if (!Shinobi::can(config('acl.user.manage', false)))
      return view('layouts.unauthorized', ['message' => 'manage user roles']);

    $roles = $user->roles;

    $available_roles = Role::whereDoesntHave('users', function($query) use ($user) {
      $query->where('user_id', $user->id);
    })->get();

    return view('user.roles', compact('user', 'roles', 'available_roles'));
  }

  /**
   * Update User Roles in storage.
   *
   * @since 0.1.0
   * @access public
   *
   * @param User $user User object.
   * @param Request
   * @return Response
   */
  public function updateUserRoles(User $user, Request $request) {
    $level = 'danger';
    $message = ' You are not permitted to update user roles.';

    if (Shinobi::can(config('acl.user.manage', false))) {
      if ($request->has('roles'))
        $user->roles()->sync($request->get('roles'));
      else
        $user->roles()->detach();

      $level = 'success';
      $message = '<i class="fa fa-check-square-o fa-1x"></i> Success! User roles edited.';
    }

    return redirect()->route('user.show', $user->id)
    ->with(['flash' => compact('message', 'level')]);
  }
}
