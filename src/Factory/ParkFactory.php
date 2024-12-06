<?php

namespace App\Factory;

use App\Entity\Park;


class ParkFactory {

    public function createSingleFromCaptainData(array $data): Park
    {
        return new Park(
            $data['parkId'],
            $data['name'],
            $data['country'],
            $data['latitude'],
            $data['longitude'],
        );
    }

}