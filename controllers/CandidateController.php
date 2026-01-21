<?php
require "../models/Candidate.php";
require "../helpers/response.php";

class CandidateController {
    private $candidate;

    public function __construct($db) {
        $this->candidate = new Candidate($db);
    }

    // READ
    public function index() {
        jsonResponse($this->candidate->getAll());
    }

    // CREATE
    public function store($data) {
        if (empty($data['name'])) {
            jsonResponse(["message" => "Nama kandidat wajib diisi"], 422);
        }

        $this->candidate->create(
            $data['name'],
            $data['vision'] ?? '',
            $data['mission'] ?? ''
        );

        jsonResponse(["message" => "Kandidat berhasil ditambahkan"]);
    }

    // UPDATE
    public function update($id, $data) {
        if (!$id) {
            jsonResponse(["message" => "ID kandidat tidak valid"], 422);
        }

        $this->candidate->update(
            $id,
            $data['name'],
            $data['vision'],
            $data['mission']
        );

        jsonResponse(["message" => "Kandidat berhasil diupdate"]);
    }

    // DELETE
    public function destroy($id) {
        if (!$id) {
            jsonResponse(["message" => "ID kandidat tidak valid"], 422);
        }

        $this->candidate->delete($id);
        jsonResponse(["message" => "Kandidat berhasil dihapus"]);
    }
}
