<?php
/*
 * CodeMOOC TreasureHuntBot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Default command message processing.
 */

require_once('lib.php');
require_once('msg_processing_registration.php');
require_once('model/context.php');

/*
 * Processes commands in text messages.
 * @param $context Context.
 * @return bool True if processed.
 */
function msg_processing_commands($context) {
    $text = $context->get_message()->text;

    if(starts_with($text, '/help')) {
        $context->reply('Help message.');

        return true;
    }
    else if(starts_with($text, '/reset')) {
        $context->reply('Reset command received. Not implemented.');

        return true;
    }
    else if(starts_with($text, '/start')) {
        $payload = extract_command_payload($text, '/start');
        if($payload === '') {
            if(null !== $context->get_group_id()) {
                $context->reply("Ciao, {$context->get_message()->get_full_sender_name()}! Sei già registrato con il gruppo _'{$context->get_group_name()}'_.");

                msg_processing_handle_group_state($context);
            }
            else {
                $context->reply("Ciao, {$context->get_message()->get_full_sender_name()}! Benvenuto alla caccia al tesoro *Urbino Code Hunting Game*. Per partecipare è necessario registrarsi, secondo le [modalità descritte sul sito](http://codemooc.org/urbino-code-hunting/), inviando il comando /register in questa chat.");
            }
        }
        else if(strlen($payload) === 16) {
            //Special treasure-hunt code sent
            echo "Treasure hunt code: {$payload}." . PHP_EOL;
        }
        else {
            echo "Unknown payload ({$payload})." . PHP_EOL;
            error_log("Unsupported /start payload ({$payload})");
        }

        return true;
    }
    else if(starts_with($text, '/register')) {
        if(null === $context->get_group_id()) {
            if(!bot_register_new_group($context)) {
                //TODO: generalize this
                $context->reply("Qualcosa è andato storto. Chi di dovere è stato avvertito.");
            }
            else {
                $context->reply("Ok, ti sei registrato per l'evento!");

                msg_processing_handle_group_state($context);
            }
        }
        else {
            $context->reply("Sei già registrato con il gruppo _'{$context->get_group_name()}'_, non c'è bisogno di registrarsi nuovamente.");

            msg_processing_handle_group_state($context);
        }

        return true;
    }

    return false;
}

 ?>
