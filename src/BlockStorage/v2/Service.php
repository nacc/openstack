<?php
namespace OpenStack\BlockStorage\v2;

use OpenStack\BlockStorage\v2\Models\Snapshot;
use OpenStack\BlockStorage\v2\Models\Volume;
use OpenStack\BlockStorage\v2\Models\VolumeType;
use OpenStack\Common\Service\AbstractService;

/**
 * @property \OpenStack\BlockStorage\v2\Api $api
 */
class Service extends AbstractService
{
    /**
     * Provisions a new bootable volume, based either on an existing volume, image or snapshot.
     * You must have enough volume storage quota remaining to create a volume of size requested.
     * 
     * @param array $userOptions {@see Api::postVolumes}
     *
     * @return Volume
     */
    public function createVolume(array $userOptions)
    {
        return $this->model(Volume::class)->create($userOptions);
    }

    /**
     * Lists all available volumes.
     * 
     * @param bool  $detail      If set to TRUE, more information will be returned.
     * @param array $userOptions {@see Api::getVolumes}
     *
     * @return \Generator
     */
    public function listVolumes($detail = false, array $userOptions = [])
    {
        $def = ($detail === true) ? $this->api->getVolumesDetail() : $this->api->getVolumes();
        return $this->model(Volume::class)->enumerate($def, $userOptions);
    }

    /**
     * @param string $volumeId The UUID of the volume being retrieved.
     *
     * @return Volume
     */
    public function getVolume($volumeId)
    {
        $volume = $this->model(Volume::class);
        $volume->populateFromArray(['id' => $volumeId]);
        return $volume;
    }

    /**
     * @param array $userOptions {@see Api::postTypes}
     *
     * @return VolumeType
     */
    public function createVolumeType(array $userOptions)
    {
        return $this->model(VolumeType::class)->create($userOptions);
    }

    /**
     * @return \Generator
     */
    public function listVolumeTypes()
    {
        return $this->model(VolumeType::class)->enumerate($this->api->getTypes(), []);
    }

    /**
     * @param string $typeId
     *
     * @return VolumeType
     */
    public function getVolumeType($typeId)
    {
        $type = $this->model(VolumeType::class);
        $type->populateFromArray(['id' => $typeId]);
        return $type;
    }

    /**
     * @param array $userOptions {@see Api::postSnapshots}
     *
     * @return Snapshot
     */
    public function createSnapshot(array $userOptions)
    {
        return $this->model(Snapshot::class)->create($userOptions);
    }

    /**
     * @return \Generator
     */
    public function listSnapshots($detail = false, array $userOptions = [])
    {
        $def = ($detail === true) ? $this->api->getSnapshotsDetail() : $this->api->getSnapshots();
        return $this->model(Snapshot::class)->enumerate($def, $userOptions);
    }

    /**
     * @param string $snapshotId
     *
     * @return Snapshot
     */
    public function getSnapshot($snapshotId)
    {
        $snapshot = $this->model(Snapshot::class);
        $snapshot->populateFromArray(['id' => $snapshotId]);
        return $snapshot;
    }
}
