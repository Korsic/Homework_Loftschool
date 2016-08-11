<?php
/*
HomeWork: 2
Task: 6
Author: Korsic
 */

function check_time() {
    echo date("d.m.t H:i") . "<br />";
}

function unix_time($date) {
    echo strtotime($date);
}


check_time();

unix_time("24.02.2016 00:00:00");