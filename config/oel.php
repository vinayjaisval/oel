<?php

return [
    // Universities tab: how many days since the later of updated_at/last_verified_at
    // before a university is flagged "needs update".
    'stale_days' => env('OEL_STALE_DAYS', 90),
];
