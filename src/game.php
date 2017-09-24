<?php
/**
 * CodeMOOC TreasureHuntBot
 * ===================
 * UWiClab, University of Urbino
 * ===================
 * Game data.
 */

const STATE_NEW             = 0;  // newly registered, captcha given
const STATE_REG_VERIFIED    = 1;  // verified as human user, name asked
const STATE_REG_NAME        = 2;  // name registered, participants asked
const STATE_REG_NUMBER      = 3;  // number of participants given, selfie asked
const STATE_REG_READY       = 10; // avatar given, ready to play
const STATE_GAME_LOCATION   = 30; // [puzzle solved], location assigned, waiting for qr code
const STATE_GAME_SELFIE     = 32; // location reached, qr code scanned, waiting for selfie
const STATE_GAME_PUZZLE     = 34; // selfie taken, puzzle assigned
const STATE_GAME_LAST_LOC   = 40; // last location assigned, waiting for qr code
const STATE_GAME_LAST_SELF  = 45; // last location reached, asked for selfie
const STATE_GAME_LAST_PUZ   = 50; // selfie taken, final puzzle assigned
const STATE_GAME_WON        = 99; // final qrcode scanned, victory

const STATE_ALL             = array(
    STATE_NEW,
    STATE_REG_VERIFIED,
    STATE_REG_NAME,
    STATE_REG_NUMBER,
    STATE_REG_READY,
    STATE_GAME_LOCATION,
    STATE_GAME_SELFIE,
    STATE_GAME_PUZZLE,
    STATE_GAME_LAST_LOC,
    STATE_GAME_LAST_SELF,
    STATE_GAME_LAST_PUZ,
    STATE_GAME_WON
);

const GAME_STATE_NEW                = 0;   // newly created, asked for confirmation
const GAME_STATE_REG_NAME           = 1;   // confirmed, asked for name
const GAME_STATE_REG_CHANNEL        = 5;   // name ok, asked for channel
const GAME_STATE_REG_EMAIL          = 10;  // channel ok, asked for e-mail
const GAME_STATE_LOCATIONS_FIRST    = 30;  // asked for first location
const GAME_STATE_LOCATIONS_LAST     = 40;  // asked for last location
const GAME_STATE_LOCATIONS          = 50;  // asked for location
const GAME_STATE_ACTIVE             = 128; // ready to accept users, play, etc.
const GAME_STATE_DEAD               = 255; // game is over

const GAME_STATE_ALL                = array(
    GAME_STATE_NEW,
    GAME_STATE_REG_NAME,
    GAME_STATE_REG_CHANNEL,
    GAME_STATE_REG_EMAIL,
    GAME_STATE_LOCATIONS_FIRST,
    GAME_STATE_LOCATIONS_LAST,
    GAME_STATE_LOCATIONS,
    GAME_STATE_ACTIVE,
    GAME_STATE_DEAD
);
