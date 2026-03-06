<?php

namespace App\Filament\Official\Resources\Announcements\Pages;

use App\Filament\Official\Resources\Announcements\AnnouncementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;
}
