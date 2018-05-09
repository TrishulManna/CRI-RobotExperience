<?php

namespace App\Http\Controllers;

use App;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
/**
 *
 */
class UserController extends Controller
{

  public $validations = [
      'name' => 'required',
      'type' => 'required',
  ];

  public function index()
  {
    $users = App\User::orderBy('created_at','asc')->get();
    if (sizeof($users) ==0 ) {
      $usernew = new App\User();
      $usernew->users();
      $users = App\User::orderBy('created_at','asc')->get();
    }
    return view('users.index')->withUsers($users);
  }

  public function update(Request $request, $id) {
      // Validate the request (also check if SQL connection can be established)
      $this->validate($request, $this->validations);

      // Get the request data as an array
      $data = $request->all();

      // Update the connection with the new information
      App\User::find($id)->update($data);
  }

  public function edit($id)
  {
Log::info('UserController: edit '.json_encode($id));
      $user = App\User::where('id', $id)->firstOrFail();

//        return view('robots.edit')->withIcon($icon);
      return view('users.edit')->withUsers($user);
  }

  public function destroy(Request $request, $user_id)
  {
      try {
          $user = App\User::where('id', $user_id)->firstOrFail();
          $user->delete();
      } catch (\Exception $e) {
          $request->session()->flash('status', 'Error!');
      } finally {
          // return redirect('icons');
      }
  }

  public function create(Request $request) {
  //        $behavior_id = $request->get('$behavior_id', false);
  //
  //        // Render view
  //        return view('robots.edit')->withBehaviorId($behavior_id);
      return view('users.edit');
  }

  public function viewSettings (){

    return view('users.settings',[
      'user' => App\User::find(Auth::user()->id)
    ]);

  }

}


?>
