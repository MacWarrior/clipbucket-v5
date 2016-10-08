<?php
require('../includes/config.inc.php');
    
    /**
    * Creates initial logs file to store translation progress related data
    * @param : { string } { $langName } { iso lang code }
    * @param : { integer } { $total } { total number of phrases that are to be translated }
    *
    * @return : { string / boolean } { full path to log file else false }
    * @since : 8th October, 2016 ClipBucket 2.8.1
    * @author : Saqib Razzaq
    */

    function initLog($langName, $total) {
        $date = date("d/M/y");
        $string = "Starting language translation \n";
        $string .= "======================================== \n";
        $string .= "Translation details \n";
        $string .= "======================================== \n";
        $string .= "Started @ ".$date."\n";
        $string .= "From English to ".$langName."\n";
        $string .= "Total phrases to translate : ".$total;
        $fullPath = FILES_DIR.'/langLog_'.$langName.'.log';
        $check = file_put_contents($fullPath, $string);
        if ($check) {
            return $fullPath;
        } else {
            return false;
        }
    }

    /**
    * Translates a given phrase and stores translation to file immediately
    * @param : { string } { $phrase } { Phrase to be translated }
    * @param : { string } { $phrase_code } { lang code of phrase to be translated }
    * @param : { string } { $to } { iso code of language that phrase is to be translated to }
    *
    * @return : { string  } { $translation } { translated string }
    * @since : 8th October, 2016 ClipBucket 2.8.1
    * @author : Saqib Razzaq
    */

    function translate_phrase($phrase, $phrase_code, $to) {
        global $MrsTranslator;
        /**
        * There is no point in starting with empty phrase
        * or invalid language code
        */

        if (!empty($phrase) && strlen($to) == 2)  {
            # Feed file to Bing API for translation
            $translation = $MrsTranslator->translate($phrase,$to,'en',"text/html");

            # In case, it failed in translation, lets give it another try
            if (!$translation) {
               $translation = $MrsTranslator->translate($phrase,$to,'en',"text/html"); 
            }

            if (!empty($translation)) {
                # build default translation log path
                $file = FILES_DIR.'/translation_'.$to.'.log';

                # check if file exists or not because handling will matter 
                if (file_exists($file)) {
                    
                    # read data of file to ease up appending
                    $existingData = file_get_contents($file);

                    # Make data readable by converting in Json
                    $data = json_decode($existingData,true);

                    # considering file is empty, lets create an array
                    if (!is_array($data)) {
                        $data = array();
                    }
                    
                    $data[$phrase_code] = $translation;
                } else {
                    $data = array();
                    $data[$phrase_code] = $translation;
                }

                if (!empty($data)) {
                    $data = json_encode($data);
                    if (!file_put_contents($file, $data)) {
                        return false;
                    }
                }

                return $translation;
            } else {
                return false;
            }
        }
    }


    if(isset($_POST['selectFieldValue'])) {
        sleep(2);
        $output = array();
        $iso_code = $_POST['selectFieldValue'];
        $language_detact = $_POST['langDetect'];
        $phrase = $_POST['phrase'];
        $phrase_code = $_POST['phrase_code'];
        $translation = translate_phrase($phrase,$phrase_code,$iso_code);
        if (!empty($translation)) {
            $output['status'] = 'success';
            $output['phrase_code'] = $phrase_code;
            $output['phrase'] = $phrase;
            $output['translation'] = $translation;
            echo json_encode($output);
        } else {
            $output['status'] = 'error';
            return false;
        }
    }

    /**
    	* Function use for translating phrases.
    	* @param : { string } { $iso } { Language code e.g "en" }
    	* 		  : {string} {$language_detact} { Language name e.g "english"}
    	* @return : { file } { save file }
    	* @since : 17 may, 2016 ClipBucket 2.8.1
    	* @author : Sikander Ali 
    	*/

    /*function language_translate($iso,$language_detact){
        global $lang_obj,$MrsTranslator;
        $language_name = $language_detact;
        $iso_code = $iso;
        $code_exists = $lang_obj->lang_exists($iso_code);
        if($code_exists == '' ){
            $percent_content = fopen(BASEDIR."/files/percent.lang","w");
            $counter = 1;
            $fileContent = $lang_obj->getPhrasesFromPack('en');
            $totalSize = count($fileContent);
            $logFile = initLog($iso_code, $totalSize);
            if (!$logFile) {
                $err = array();
                $err['error'] = "Unable to create log file for language";
                echo json_encode($err);
                exit();
            }
              foreach ($fileContent as $key => $value) {
                $langLogData = file_get_contents($logFile);
                $phrase_code = $key;
                $newLang[$key] = str_replace('', '+', $value);
                $newlang[$key] = $MrsTranslator->translate($value,$iso_code,'en',"text/html");
                $percentageCal = ($counter/$totalSize)*100;
                $interger_val = intval($percentageCal); 
                if (!empty($newLang[$key])) {
                    file_put_contents($logFile, $langLogData."\n"."[DONE] ".$counter." / ".$totalSize." [$interger_val %] Translated phrase : $value");
                } else {
                    file_put_contents($logFile, $langLogData."\n"."Something went wrong trying to convert : $value");
                }
                file_put_contents(BASEDIR."/files/percent.lang", $interger_val."\n");
                $counter++;
             }
            $lang_obj->import_packlang($iso_code,$newlang,$language_name);
            $lang_obj->createPack($iso_code);
            fclose($percent_content);
            $id = mysql_clean($_POST['make_default']);
            $lang_obj->make_default($id);
            $response['iso-code_exits'] = $code_exists;
            $response['set'] = false;
            echo json_encode($response);
        }else{
            $message = "Code Already Exists";
            $response['message'] = $message;
            echo json_encode($response);
        }
    }*/