<?php 
namespace Core;

use Exception;
use Core\Database\DB;
use Core\Interfaces\ValidatorInterface;

class Validator implements ValidatorInterface
{
    private $messages = [];
    private static $self = null;
    
    public static function make($request, $rules, $messages, $atributes = []){
        self::$self = new self();  
        try{
            if (!empty($request) && is_array($request)){
                if (!empty($rules)){
                    foreach ($rules as $field => $ruleList){
                        $ruleListArr = array_filter(explode('|', $ruleList));
                        if (!empty($ruleListArr)){
                            foreach ($ruleListArr as $ruleItem){

                                $ruleValue = null;



                                if (strpos($ruleItem, ':')!==false){
                                    $ruleItemArr = array_filter(explode(':', $ruleItem));
                                    $ruleName = $ruleItemArr[0];
                                    $ruleValue = $ruleItemArr[1];
                                    
                                }else {
                                    $ruleName = $ruleItem;
                                }

                                // Xử lý rule required
                                if ($ruleName == 'required'){
                                    if (isset($request[$field]) && $request[$field]==''){
                                        self::$self->setMessages($messages[$ruleName], $field, $atributes);
                                        
                                    }
                                }

                                if ($ruleName == 'min' && !empty($ruleValue)){
                                    if (isset($request[$field]) && mb_strlen($request[$field], 'UTF-8') < $ruleValue){
                                        self::$self->setMessages($messages[$ruleName], $field, $atributes, [
                                            ':min' => $ruleValue
                                        ]);
                                    }
                                }

                                if ($ruleName == 'max' && !empty($ruleValue)){
                                    if (isset($request[$field]) && mb_strlen($request[$field], 'UTF-8') > $ruleValue){
                                        self::$self->setMessages($messages[$ruleName], $field, $atributes, [
                                            ':max' => $ruleValue
                                        ]);
                                    }
                                }

                                if ($ruleName == 'email'){
                                    if (isset($request[$field]) && !filter_var($request[$field], FILTER_VALIDATE_EMAIL)){
                                        self::$self->setMessages($messages[$ruleName], $field, $atributes);
                                    }
                                }

                                if ($ruleName == 'same' && !empty($ruleValue)){
                                    if (isset($request[$field]) && isset($request[$ruleValue]) && $request[$ruleValue]!=$request[$field]){
                                        
                                        self::$self->setMessages($messages[$ruleName], $field, $atributes,
                                        
                                        [
                                            
                                            ':same' => $atributes[$ruleValue] ?? $ruleValue
                                        ]
                                            
                                        );
                                    }
                                }
                                if ($ruleName == 'unique' && !empty($ruleValue && isset($request[$field]))){
                                    $ruleValueArr = array_filter(explode(',', $ruleValue));
                                    if(!empty($ruleValueArr[0]) && !empty($ruleValueArr[1])){
                                        $tableName = $ruleValueArr[0];
                                        $fieldName = $ruleValueArr[1];

                                        $sql = "SELECT * FROM $tableName WHERE $fieldName = ?";

                                        $data = [$request[$field]];
                                        
                                        
                                        if ($ruleValueArr[2]){
                                            $ignoreValue = $ruleValueArr[2];
                                            $row = DB::first("SELECT 
                                            KU.table_name as TABLENAME
                                           ,column_name as 'primary'
                                       FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS TC 
                                       
                                       INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KU
                                           ON TC.CONSTRAINT_TYPE = 'PRIMARY KEY' 
                                           AND TC.CONSTRAINT_NAME = KU.CONSTRAINT_NAME 
                                           AND KU.table_name='users'
                                       
                                       ORDER BY 
                                            KU.TABLE_NAME
                                           ,KU.ORDINAL_POSITION
                                       LIMIT 1;");

                                            if(!empty($row)){
                                                $primaryKey = $row['primary'];
                                            }
                                            $sql.= "AND $primaryKey != ?";
                                            $data[] = $ignoreValue;

                                        }

                                        $count = DB::count($sql, $data);

                                        if ($count > 0){
                                            self::$self->setMessages($messages[$ruleName], $field, $atributes);
                                        }

                                    } 
                                }
                            }
                        }
                    }
                     
                   //Xử lý gán message cho session
                   Session::put('validate_errors', self::$self->messages); 
                   Session::put('validate_old', $request);                     
                }
            }else{
                throw new Exception('$request không đúng định dạng');
            }
        }catch(Exception $exception){
            echo $exception->getMessage();
            die();
        }
        return self::$self;
    }

    // public function getMessage(){
    //     return $this->messages;
    // }

    public function passes(){
        return $this->isValidate();
    }

    public function fails(){
        return !$this->isValidate();
    }

    private function setMessages($messagesTemplate, $field, $atributes, $variables = []){
        $fieldTitle = !empty($atributes[$field]) ? $atributes[$field]: $field;
        $messagesTemplate = str_replace(':attribute', $fieldTitle, $messagesTemplate);
        if (!empty($variables)){
            foreach ($variables as $key => $value){
                $messagesTemplate = str_replace($key, $value, $messagesTemplate);
            }
        }
        self::$self->messages[$field][] = $messagesTemplate;
        
    }

    private function isValidate(){
        return empty($this->messages);
    }

}
