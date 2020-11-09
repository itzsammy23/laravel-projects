<?php

function checkSubscription(\App\User $user) {
    $currentDate = date('Y-m-d');
    $currentDateTime = new DateTime($currentDate);
    $dateCreated = $user->created_at->format('Y-m-d');
    $dateCreatedTime = new DateTime($dateCreated);
    $interval = $currentDateTime->diff($dateCreatedTime);
    $daysUsed = $interval->days;
    $dateUpdated = $user->updated_at->format('Y-m-d');
    $dateUpdatedTime = new DateTime($dateUpdated);
    $newInterval = $currentDateTime->diff($dateUpdatedTime);
    $newDate = $newInterval->days;
    $daysLeft = 90 - $daysUsed;

    if($user->usingFreeSubscription == "true") {
        if($daysLeft == 0) {
            $user->update([
                "usingFreeSubscription" => "false",
                "isEligible" => "false",
            ]);
        }

        session(['days_left' => $daysLeft]);

    } else if ($user->usingPaidSubscription == "true") {

        $daysTillNewSub = 180 - $newDate;


        if($daysTillNewSub === 0) {
            $user->update([
                "usingPaidSubscription" => "false",
                "isEligible" => "false",
            ]);
        }


        session(['days_left' => $daysTillNewSub]);
    } else {
        $user->update([
            "isEligible" => "false",
            "usingFreeSubscription" => "false",
            "usingPaidSubscription" => "false",
        ]);
        session(['days_left' => 0]);
    }

};
