<?php

namespace App\Entities\Forms;

class ZvonokLeadForm
{
    public string $name;
    public string $phone;
    public string $tag;
    public int $projectId;

    public static function makeFromRequest(array $request): ZvonokLeadForm
    {
        $e = new self;
        $e->name = $request['phone'];
        $e->phone = $request['phone'];
        $e->tag = $request['tag'];

        return $e;
    }

    /**
     * @param int $projectId
     */
    public function setProjectId(int $projectId): void
    {
        $this->projectId = $projectId;
    }
}