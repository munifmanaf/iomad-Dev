<?php

require_once('../config.php');
global $CFG, $DB, $USER, $OUTPUT;
require_once($CFG->dirroot.'/test/form.php');
// require_once($CFG->wwwroot.'index_form.php');
// Instantiate the myform form from within the plugin.
$redirect = $CFG->wwwroot.'/test/index.php';
echo $OUTPUT->header();
$mform = new simplehtml_form();

$idid = optional_param('id', 0, PARAM_INT);
$entry = new stdClass;
if($idid < 1){
    $entry->id = null;
}else{
    $entry = $DB->get_record('emailtest', array('id' => $idid), '*', MUST_EXIST);
}

// $context = CONTEXT_SYSTEM::instance();

// $draftid_editor = file_get_submitted_draft_itemid('userattachments');
// $currenttext = file_prepare_draft_area(
//     $draftid_editor,
//     $context->id,
//     'ram_component',
//     'ram_filearea',
//     $entry->id,
//     array(
//         'subdirs' => 0,
//         'maxbytes' => $maxbytes,
//         'maxfiles' => 1
//     )
// );

// $entry->userattachments = $draftid_editor;

// $mform->set_data($entry);
// print_r($USER);
// Form processing and displaying is done here.
if ($mform->is_cancelled()) {
    echo "Bye";
} else if ($fromform = $mform->get_data()) {
    // insert into db
    $data = new stdClass;
    $data->email = $fromform->email;
    $data->added_time = time();
    $data->added_by = $USER->id;

    // $file = $mform->get_new_filename('userfile');
    // $fullpath = '../test/upload/'.$file;
    // $success = $mform->save_file('userfile', $fullpath, $override);

    $data->file_path = $fullpath;

    // if(!$success){
    //     echo "Apa ini ?";
    // }else{
        $db_ins = $DB->insert_record('emailtest', $data);

        if ($data = $mform->get_data()) {
            // ... store or update $entry.
        
            // Now save the files in correct part of the File API.
            file_save_draft_area_files(
                // The $data->attachments property contains the itemid of the draft file area.
                $fromform->userattachments,
        
                // The combination of contextid / component / filearea / itemid
                // form the virtual bucket that file are stored in.
                $context->id,
                'ram_component',
                'ram_filearea',
                $db_ins,
        
                [
                    'subdirs' => 0,
                    'maxbytes' => $maxbytes,
                    'maxfiles' => 1,
                ]
            );
        }

        if(!$db_ins){
            echo "Apa podah ?";
        }else{
            redirect($redirect, get_string('Successfully Saved'), null, \core\output\notification::NOTIFY_SUCCESS);
        }
    // }

} else {
    // Set anydefault data (if any).
    $mform->set_data($toform);

    // Display the form.
    $mform->display();
}

echo $OUTPUT->footer();

?>