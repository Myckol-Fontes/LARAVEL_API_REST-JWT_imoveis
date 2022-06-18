<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\ApiMessages;
use App\Models\RealStatePhoto;

class RealStatePhotoController extends Controller
{
    private $realStatePhoto;

    public function __construct(RealStatePhoto $realStatePhoto){
        $this->realStatePhoto = $realStatePhoto;
    }

    public function setThumb($photoId, $realStateId){
        try {
            $photo = $this->realStatePhoto
            ->where('real_state_id', $realStateId)
            ->where('is_thumb', true);

            if($photo->count()) $photo->first()->update(['is_thumb' => false]);

            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);

            return response()->json([
                'data' => [
                    'msg' => 'Thumb atualizado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function remove($photoId){
        try {
            $photo = $this->realStatePhoto->find($photoId);

            if($photo->is_thumb){
                $message = new ApiMessages('Erro, selecione outra thumb para remover a imagem');
            return response()->json($message->getMessage(), 401);
            }

            if($photo){
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }

            return response()->json([
                'data' => [
                    'msg' => 'Thumb deletada com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
