<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Api\ApiMessages;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate('10');

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password')){
            $message = new ApiMessages('É necessário informar uma senha!');
            return response()->json($message->getMessage(), 401);
        }

        Validator::make($data, [
            'phone' => 'required',
            'mobile_phone' => 'required'
        ]);

        try{

            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);
            $user->profile()->create([
                'phone' => $data['phone'],
                'mobile_phone' => $data['mobile_phone']
            ]);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário cadastrado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $user = $this->user->findOrFail($id);

            return response()->json([
                'data' => $user
            ], 200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if($request->has('password') && $request->get('password')){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        try{
            $user = $this->user->findOrFail($id);
            $user->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário atualizado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = $this->user->findOrFail($id);
            $user->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Usuário deletado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}