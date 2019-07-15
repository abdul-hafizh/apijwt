<?php

if ( ! function_exists('fuc_checktoken'))
{ 
    function fuc_checktoken($token)
    {
        $ci = get_instance();
        
        $token = str_replace('Bearer ','',$token['Authorization']);
        $check = $ci->db->where(array('token'=>$token))->get('api_token');
        if($check->num_rows()>0){
            $indate = strtotime($check->row()->datein);
            $today = strtotime(date('Y-m-d h:i:s'));
            
            $expire = strtotime(date('Y-m-d h:i:s', strtotime($check->row()->datein . ' +1 days')));
            
            if($today>=$expire){ 
                // jika lebih dari 24 jam
                $tokenData['uniqueId'] = $check->row()->iduser;
                $tokenData['timeStamp'] = date('Y-m-d h:i:s');
                
                $jwtToken = $ci->objOfJwt->GenerateToken($tokenData);
                
                $data1 = array(
                    'iduser'=>$check->row()->iduser,
                    'token'=>$jwtToken,
                    'datein'=>Date('Y-m-d h:i:s'),
                    );
                    
                $ci->db->where(array('iduser'=>$check->row()->iduser))->update('api_token',$data1);
                                
                $response = array(
                    'status' => false,
                    'data' => array(
                        'token'=>$jwtToken
                        ),
                    'message' => 'Expired! kami mengirim data token baru.'
                );
                
                $ci->output
                  ->set_status_header(401)
                  ->set_content_type('application/json', 'utf-8')
                  ->set_output(json_encode($response, JSON_PRETTY_PRINT))
                  ->_display();
                  exit;
               
            }else{
                return true;
            }
        }else{
            
            $response = array(
                'status' => false,
                'data' => null,
                'message' => 'Unauthorized!'
            );
            
            $ci->output
              ->set_status_header(401)
              ->set_content_type('application/json', 'utf-8')
              ->set_output(json_encode($response, JSON_PRETTY_PRINT))
              ->_display();
              exit;
            
        }
    }
}




