<?php
namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class LogoutController extends Controller
{
/**
* Handle the incoming request.
*
* @param Request $request
* @return RedirectResponse
*/
public function __invoke(Request $request): RedirectResponse
{
auth()->logout();
return redirect()->route('posts.index')->with('success', 'You have been disconnected');
}
}
