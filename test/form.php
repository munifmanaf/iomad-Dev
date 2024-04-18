<?php

require_once("$CFG->libdir/formslib.php");

class simplehtml_form extends moodleform {
    // Add elements to form.
    public function definition() {
        // A reference to the form is stored in $this->form.
        // A common convention is to store it in a variable, such as `$mform`.
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'name', get_string('name'));
        // Set type of element.
        $mform->setType('name', PARAM_NOTAGS);
        
        $mform->addRule('name', 'Insert Name', 'required', null, 'server');
        // Add elements to your form.
        $mform->addElement('text', 'email', get_string('email'));
        // Set type of element.
        $mform->setType('email', PARAM_NOTAGS);

        $mform->addRule('email', get_string('missingemail'), 'required', null, 'server');

        $maxbytes = get_max_upload_sizes();

        // $mform->addElement(
        //     'filepicker',
        //     'userfile',
        //     get_string('file'),
        //     null,
        //     [
        //         'maxbytes' => $maxbytes,
        //         'accepted_types' => '*',
        //     ]
        // );

        // $mform->addElement(
        //     'filemanager',
        //     'userattachments',
        //     'File',
        //     null,
        //     [
        //         'subdirs' => 0,
        //         'maxbytes' => $maxbytes,
        //         'areamaxbytes' => 10485760,
        //         'maxfiles' => 1,
        //         'accepted_types' => '*',
        //         'return_types' => FILE_INTERNAL | FILE_EXTERNAL,
        //     ]
        // );

        $this->add_action_buttons();
    }

    // Custom validation should be added here.
    function validation($data, $files) {
        return [];
    }
}


?>