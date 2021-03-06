<?php
/*
 * CodeMOOC TreasureHuntBot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Helpers for common message processing / messaging functions.
 */

/**
 * Processes a victory by the user, for a given game or event.
 */
function msg_process_victory($context, $event_id = null, $game_id = null) {
    if($event_id === null && $game_id === null) {
        $game_id = $context->game->game_id;
    }

    $result = bot_direct_win($context, $event_id, $game_id);
    if($result === 'wrong') {
        $context->comm->reply(__('cmd_start_wrong_payload'));
    }
    else if($result === 'unallowed_event_not_ready') {
        $context->comm->reply(__('failure_event_not_ready'));
    }
    else if($result === 'unallowed_event_over') {
        $context->comm->reply(__('failure_event_over'));
    }
    else if($result === 'unallowed_game_not_ready') {
        $context->comm->reply(__('failure_game_not_ready'));
    }
    else if($result === 'unallowed_game_over') {
        $context->comm->reply(__('failure_game_dead'));
    }
    else if($result === 'too_soon') {
        // Invalid state, cannot win game yet/again
        $context->comm->reply(__('cmd_start_prize_invalid'));
    }
    else if(is_array($result)) {
        if($result[0] === 'first') {
            $context->comm->reply(__('cmd_start_prize_first'));
            $context->comm->channel(__('cmd_start_prize_channel_first'));
        }
        else {
            $context->comm->reply(__('cmd_start_prize_not_first'), array(
                '%WINNING_GROUP%' => $result[1],
                '%INDEX%' => $result[2]
            ));
            $context->comm->channel(__('cmd_start_prize_channel_not_first'), array(
                '%INDEX%' => $result[2]
            ));
        }

        // Send out questionnaire starting option
        $context->memorize_callback(
            $context->comm->reply(
                __('questionnaire_init_question'),
                null,
                array("reply_markup" => array(
                    "inline_keyboard" => array(
                        array(
                            array("text" => __('questionnaire_init_question_response'), "callback_data" => "questionnaire")
                        )
                    )
                ))
            )
        );
    }
    else {
        $context->comm->reply(__('failure_general'));
    }
}
