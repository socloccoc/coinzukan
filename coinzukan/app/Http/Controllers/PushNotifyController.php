<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PushNotify;
use Illuminate\Http\Response;
use App\Models\Pair;
class PushNotifyController extends Controller
{
   
    public function registryInfoDevice(Request $request){
        try {
            $marketID = $request->input('market_id');
            $base_target = $request->input('base_target');
            $token = $request->input('token');
            $uuid = $request->input('uuid');
            $value_above = $request->input('value_above');
            $value_below = $request->input('value_below');
            $status = $request->input('status');
            $type_push = $request->input('type_push');
            $device_os = $request->input('device_os');
            
              $checkPushExits = PushNotify::where("base_target",$base_target)
                                        ->where('market_id',$marketID)
                                        ->where ('token',$token)
                                        ->where ('uuid',$uuid)
                                        ->where ('value_above',$value_above)
                                        ->where ('value_below',$value_below)
                                        ->where ('status',$status)
                                        ->where ('type_push',$type_push)
                                        ->where ('device_os',$device_os)
                                        ->first();

            if(is_null($checkPushExits)){    
              
                $pushNotify = new PushNotify();
                $pushNotify->market_id = $marketID;
                $pushNotify->base_target = $base_target;
                $pushNotify->token = $token;
                $pushNotify->uuid = $uuid;
                $pushNotify->value_above = $value_above;
                $pushNotify->value_below = $value_below;
                $pushNotify->device_os = $device_os;
                $pushNotify->status = $status;
                $pushNotify->type_push = $type_push;
    
                $pushNotify->save();
                $response = $this->responseData(true,'create success',$pushNotify);
            }   else{
                $response = $this->responseData(false,'create fail, exits alert','');       
            }
            
      
            } catch (Illuminate\Database\QueryException $ex) {
                $response = $this->responseData(false,'error',$ex);    

            } catch (PDOException $e) {
                $response = $this->responseData(false,'error',$e);    
            }  
            return $response;
    }

    public function updateArlert(Request $request){
    
            try { 
                $id = $request->input('id');
                $marketID = $request->input('market_id');
                $base_target = $request->input('base_target');
                $token = $request->input('token');
                $uuid = $request->input('uuid');
                $value_above = $request->input('value_above');
                $value_below = $request->input('value_below');
                $status = $request->input('status');
                $type_push = $request->input('type_push');
                $device_os = $request->input('device_os');
                
                $pushNotify = PushNotify::where("id",$id)
                                            ->first();
               
                if(!is_null($pushNotify)){    
                  
                    $pushNotify->market_id = $marketID;
                    $pushNotify->base_target = $base_target;
                    $pushNotify->token = $token;
                    $pushNotify->uuid = $uuid;
                    $pushNotify->value_above = $value_above;
                    $pushNotify->value_below = $value_below;
                    $pushNotify->device_os = $device_os;
                    $pushNotify->status = $status;
                    $pushNotify->type_push = $type_push;
                    $pushNotify->save();
                    $response = $this->responseData(true,'update success',$pushNotify);
                }   else{
                    $response = $this->responseData(false,'update fail, not exits alert','');       
                }
                
          
                } catch (Illuminate\Database\QueryException $ex) {
                    $response = $this->responseData(false,'error',$ex);    
    
                } catch (PDOException $e) {
                    $response = $this->responseData(false,'error',$e);    
                }  
                return $response;
        
    }


    public function deleteArlert(Request $request){
        
        try { 
            $id = $request->input('id');
            $deleteNotify = PushNotify::where("id",$id)->delete();
              
            $response = $this->responseData(true,' success','');

            } catch (Illuminate\Database\QueryException $ex) {
                $response = $this->responseData(false,'error',$ex);    

            } catch (PDOException $e) {
                $response = $this->responseData(false,'error',$e);    
            }  
            return $response;
            
        }

    public function getAlerByToken(Request $request){

                try { 
                    $token = $request->input('token');
                    $getNotify = PushNotify::select('push_notfication.id','push_notfication.market_id','markets.market_name','push_notfication.token',
                                                'push_notfication.uuid','push_notfication.base_target','push_notfication.value_above','push_notfication.value_below',
                                                'push_notfication.status','push_notfication.type_push')
                                                ->where("token",$token)
                                                ->join ('markets' ,'push_notfication.market_id', '=', 'markets.id')
                                                ->get();

                    foreach ($getNotify as $item){
                        $item['market_id'] = intval($item['market_id']);
                        $item['value_above'] = floatval($item['value_above']);
                        $item['value_below'] = floatval($item['value_below']);
                        $item['status'] = floatval($item['status']);
                        $item['type_push'] = floatval($item['type_push']);
                        }
                                                                              
                    $response = $this->responseData(true,' success',$getNotify);
        
                    } catch (Illuminate\Database\QueryException $ex) {
                        $response = $this->responseData(false,'error',$ex);    
        
                    } catch (PDOException $e) {
                        $response = $this->responseData(false,'error',$e);    
                    }  
                    return $response;
            
        }

      
        public function getAlerByBaseTarget(Request $request){
            
                            try { 
                                $token = $request->input('token');
                                $base_target = $request->input('base_target');
                                $getNotify = PushNotify::select('push_notfication.id','push_notfication.market_id','markets.market_name','push_notfication.token',
                                                            'push_notfication.uuid','push_notfication.base_target','push_notfication.value_above','push_notfication.value_below',
                                                            'push_notfication.status','push_notfication.type_push')
                                                            ->where("token",$token)
                                                            ->where("base_target",$base_target)
                                                            ->join ('markets' ,'push_notfication.market_id', '=', 'markets.id')
                                                            ->get();
                                  
                                foreach ($getNotify as $item){
                                    $item['market_id'] = intval($item['market_id']);
                                    $item['value_above'] = floatval($item['value_above']);
                                    $item['value_below'] = floatval($item['value_below']);
                                    $item['status'] = floatval($item['status']);
                                    $item['type_push'] = floatval($item['type_push']);
                                }
                                   
                                $response = $this->responseData(true,' success',$getNotify);
                    
                                } catch (Illuminate\Database\QueryException $ex) {
                                    $response = $this->responseData(false,'error',$ex);    
                    
                                } catch (PDOException $e) {
                                    $response = $this->responseData(false,'error',$e);    
                                }  
                                return $response;
                        
                    }

    public function statusNotifys(Request $request){
            try { 
                $base_target = $request->input('base_target');
                $token = $request->input('token');
                $status = $request->input('status');
            
                $pushNotify = PushNotify::select('push_notfication.id','push_notfication.market_id','push_notfication.token',
                                            'push_notfication.uuid','push_notfication.base_target','push_notfication.value_above','push_notfication.value_below',
                                            'push_notfication.status','push_notfication.type_push')
                                        ->where("base_target",$base_target)
                                        ->where("token",$token)
                                        ->get();
                if(count($pushNotify) > 0){
                  
                    foreach($pushNotify as $notifyData){
                        $notifyData->status = $status;
                        $notifyData->save();
                    }
                    $response = $this->responseData(true,'change status success','');
                 }
                 else{
                    $response = $this->responseData(false,'change status fail, not exits alerts','');
                 }
                
            } catch (Illuminate\Database\QueryException $ex) {
                $response = $this->responseData(false,'error',$ex);    

            } catch (PDOException $e) {
                $response = $this->responseData(false,'error',$e);    
            }  
    return $response;
    }
    private function responseData($status,$message,$data){
        return response()->json(['success' => $status,'message'=>$message,'data'=>$data], 200);
    }


}
