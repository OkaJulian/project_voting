<?php
require "../models/Vote.php";
require "../helpers/response.php";

class VoteController {
    private $vote;

    public function __construct($db) {
        $this->vote = new Vote($db);
    }

    public function vote($user_id, $candidate_id) {
        if ($this->vote->hasVoted($user_id)) {
            jsonResponse(["message" => "Anda sudah melakukan voting"], 403);
        }

        $this->vote->vote($user_id, $candidate_id);
        jsonResponse(["message" => "Voting berhasil"]);
    }

    public function results() {
        jsonResponse($this->vote->results());
    }
}
