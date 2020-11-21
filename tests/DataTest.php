<?php

declare(strict_types=1);

include_once __DIR__ . '/stubs/GlobalStubs.php';
include_once __DIR__ . '/stubs/KernelStubs.php';
include_once __DIR__ . '/stubs/ModuleStubs.php';

use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
    protected function setUp(): void
    {
        //Reset
        IPS\Kernel::reset();

        //Register our core stubs for testing
        IPS\ModuleLoader::loadLibrary(__DIR__ . '/stubs/IOStubs/library.json');

        //Register our library we need for testing
        IPS\ModuleLoader::loadLibrary(__DIR__ . '/../library.json');

        //Create required profiles
        if (!IPS\ProfileManager::variableProfileExists('~Switch')) {
            IPS\ProfileManager::createVariableProfile('~Switch', 0);
        }
        if (!IPS\ProfileManager::variableProfileExists('~Temperature')) {
            IPS\ProfileManager::createVariableProfile('~Temperature', 2);
        }
        if (!IPS\ProfileManager::variableProfileExists('~Electricity')) {
            IPS\ProfileManager::createVariableProfile('~Electricity', 2);
        }
        if (!IPS\ProfileManager::variableProfileExists('~Gas')) {
            IPS\ProfileManager::createVariableProfile('~Gas', 2);
        }

        parent::setUp();
    }

    public function test_evt_precip(): void
    {
        $io_id = IPS_CreateInstance('{6179ED6A-FC31-413C-BB8E-1204150CF376}');
        $iid = IPS_CreateInstance('{3E8264A7-828C-6C3D-F394-FBA43CC81B1D}');
        IPS_ConnectInstance($iid, $io_id);

        VIO_PushText($io_id, file_get_contents(__DIR__ . '/data/evt_precip.json'));

        $this->assertTrue(GetValue(IPS_GetObjectIDByIdent('SK_00008453_evt_precip_0', $iid)));
    }

    public function test_evt_strike(): void
    {
        $io_id = IPS_CreateInstance('{6179ED6A-FC31-413C-BB8E-1204150CF376}');
        $iid = IPS_CreateInstance('{3E8264A7-828C-6C3D-F394-FBA43CC81B1D}');
        IPS_ConnectInstance($iid, $io_id);

        VIO_PushText($io_id, file_get_contents(__DIR__ . '/data/evt_strike.json'));

        $this->assertTrue(GetValue(IPS_GetObjectIDByIdent('AR_00004049_evt_strike_0', $iid)));
        $this->assertEquals(27, GetValue(IPS_GetObjectIDByIdent('AR_00004049_evt_strike_1', $iid)));
        $this->assertEquals(3848, GetValue(IPS_GetObjectIDByIdent('AR_00004049_evt_strike_2', $iid)));
    }

    public function test_rapid_wind(): void
    {
        $io_id = IPS_CreateInstance('{6179ED6A-FC31-413C-BB8E-1204150CF376}');
        $iid = IPS_CreateInstance('{3E8264A7-828C-6C3D-F394-FBA43CC81B1D}');
        IPS_ConnectInstance($iid, $io_id);

        VIO_PushText($io_id, file_get_contents(__DIR__ . '/data/rapid_wind.json'));

        $this->assertTrue(GetValue(IPS_GetObjectIDByIdent('SK_00008453_rapid_wind_0', $iid)));
        $this->assertEquals(2.3, GetValue(IPS_GetObjectIDByIdent('SK_00008453_rapid_wind_1', $iid)));
        $this->assertEquals(128, GetValue(IPS_GetObjectIDByIdent('SK_00008453_rapid_wind_2', $iid)));
    }

    /*
    public function test_obs_air(): void
    {
        $io_id = IPS_CreateInstance('{6179ED6A-FC31-413C-BB8E-1204150CF376}');
        $iid = IPS_CreateInstance('{3E8264A7-828C-6C3D-F394-FBA43CC81B1D}');
        IPS_ConnectInstance($iid, $io_id);

        VIO_PushText($io_id, file_get_contents(__DIR__ . '/data/obs_air.json'));

        $this->assertTrue(GetValue(IPS_GetObjectIDByIdent("AR_00004049_obs_air_0", $iid)));
        $this->assertEquals(835.0, GetValue(IPS_GetObjectIDByIdent("AR_00004049_obs_air_1", $iid)));
        $this->assertEquals(10.0, GetValue(IPS_GetObjectIDByIdent("AR_00004049_obs_air_2", $iid)));
        $this->assertEquals(45, GetValue(IPS_GetObjectIDByIdent("AR_00004049_obs_air_3", $iid)));
        $this->assertEquals(0, GetValue(IPS_GetObjectIDByIdent("AR_00004049_obs_air_4", $iid)));
        $this->assertEquals(0, GetValue(IPS_GetObjectIDByIdent("AR_00004049_obs_air_5", $iid)));
        $this->assertEquals(3.46, GetValue(IPS_GetObjectIDByIdent("AR_00004049_obs_air_6", $iid)));
        $this->assertEquals(1, GetValue(IPS_GetObjectIDByIdent("AR_00004049_obs_air_7", $iid)));
    }
     */

    /*
    public function test_obs_sky(): void
    {
        $io_id = IPS_CreateInstance('{6179ED6A-FC31-413C-BB8E-1204150CF376}');
        $iid = IPS_CreateInstance('{3E8264A7-828C-6C3D-F394-FBA43CC81B1D}');
        IPS_ConnectInstance($iid, $io_id);

        VIO_PushText($io_id, file_get_contents(__DIR__ . '/data/obs_sky.json'));

        $this->assertTrue(GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_0", $iid)));
        $this->assertEquals(9000, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_1", $iid)));
        $this->assertEquals(10, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_2", $iid)));
        $this->assertEquals(0.0, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_3", $iid)));
        $this->assertEquals(2.6, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_4", $iid)));
        $this->assertEquals(4.6, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_5", $iid)));
        $this->assertEquals(7.4, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_6", $iid)));
        $this->assertEquals(187, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_7", $iid)));
        $this->assertEquals(3.12, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_8", $iid)));
        $this->assertEquals(1, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_9", $iid)));
        $this->assertEquals(130, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_10", $iid)));
        $this->assertEquals(0, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_11", $iid)));
        $this->assertEquals(0, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_12", $iid)));
        $this->assertEquals(3, GetValue(IPS_GetObjectIDByIdent("SK_00008453_obs_sky_13", $iid)));
    }
     */

    public function test_obs_st(): void
    {
        $io_id = IPS_CreateInstance('{6179ED6A-FC31-413C-BB8E-1204150CF376}');
        $iid = IPS_CreateInstance('{3E8264A7-828C-6C3D-F394-FBA43CC81B1D}');
        IPS_ConnectInstance($iid, $io_id);

        VIO_PushText($io_id, file_get_contents(__DIR__ . '/data/obs_st.json'));

        $this->assertTrue(GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_0', $iid)));
        $this->assertEquals(0.18, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_1', $iid)));
        $this->assertEquals(0.22, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_2', $iid)));
        $this->assertEquals(0.27, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_3', $iid)));
        $this->assertEquals(144, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_4', $iid)));
        $this->assertEquals(6, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_5', $iid)));
        $this->assertEquals(1017.57, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_6', $iid)));
        $this->assertEquals(22.37, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_7', $iid)));
        $this->assertEquals(50.26, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_8', $iid)));
        $this->assertEquals(328, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_9', $iid)));
        $this->assertEquals(0.03, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_10', $iid)));
        $this->assertEquals(3, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_11', $iid)));
        $this->assertEquals(0.000000, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_12', $iid)));
        $this->assertEquals(0, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_13', $iid)));
        $this->assertEquals(0, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_14', $iid)));
        $this->assertEquals(0, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_15', $iid)));
        $this->assertEquals(2.410, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_16', $iid)));
        $this->assertEquals(1, GetValue(IPS_GetObjectIDByIdent('ST_00000512_obs_st_17', $iid)));
    }
}