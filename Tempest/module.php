<?php

declare(strict_types=1);

class Tempest extends IPSModule
{
    public function Create()
    {
        parent::Create();

        $this->RequireParent('{82347F20-F541-41E1-AC5B-A636FD3AE2D8}');
    }

    public function GetConfigurationForParent()
    {
        return json_encode([
            'Host'               => '',
            'Port'               => 0,
            'BindIP'             => '0.0.0.0',
            'BindPort'           => 50222,
            'EnableBroadcast'    => true,
            'EnableReuseAddress' => true
        ]);
    }

    public function ReceiveData($JSONString)
    {
        $data = json_decode($JSONString, true);
        $data = json_decode($data['Buffer'], true);

        $ident = function ($index) use ($data)
        {
            return str_replace('-', '_', $data['serial_number']) . '_' . $data['type'] . '_' . $index;
        };

        switch ($data['type']) {
            case 'evt_precip':
                $this->RegisterVariableBoolean($ident(0), 'Rain Start Event');
                $this->SetValue($ident(0), true);
                break;
            case 'evt_strike':
                $this->RegisterVariableBoolean($ident(0), 'Lightning Strike Event');
                $this->SetValue($ident(0), true);
                $this->RegisterVariableInteger($ident(1), 'Lightning Strike Distance');
                $this->SetValue($ident(1), $data['evt'][1]);
                $this->RegisterVariableInteger($ident(2), 'Lightning Strike Energy');
                $this->SetValue($ident(2), $data['evt'][2]);
                break;
            case 'rapid_wind':
                $this->RegisterVariableBoolean($ident(0), 'Rapid Wind');
                $this->SetValue($ident(0), true);
                $this->RegisterVariableFloat($ident(1), 'Rapid Wind Speed');
                $this->SetValue($ident(1), $data['ob'][1]);
                $this->RegisterVariableInteger($ident(2), 'Rapid Wind Direction');
                $this->SetValue($ident(2), $data['ob'][2]);
                break;
            case 'obs_st':
                foreach ($data['obs'] as $obs) {
                    $this->RegisterVariableBoolean($ident(0), 'Observation (Tempest)');
                    $this->SetValue($ident(0), true);
                    $this->RegisterVariableFloat($ident(1), 'Wind Lull');
                    $this->SetValue($ident(1), $obs[1]);
                    $this->RegisterVariableFloat($ident(2), 'Wind Avg');
                    $this->SetValue($ident(2), $obs[2]);
                    $this->RegisterVariableFloat($ident(3), 'Wind Gust');
                    $this->SetValue($ident(3), $obs[3]);
                    $this->RegisterVariableInteger($ident(4), 'Wind Direction');
                    $this->SetValue($ident(4), $obs[4]);
                    $this->RegisterVariableInteger($ident(5), 'Wind Sample Interval');
                    $this->SetValue($ident(5), $obs[5]);
                    $this->RegisterVariableFloat($ident(6), 'Station Pressure');
                    $this->SetValue($ident(6), $obs[6]);
                    $this->RegisterVariableFloat($ident(7), 'Air Temperature');
                    $this->SetValue($ident(7), $obs[7]);
                    $this->RegisterVariableFloat($ident(8), 'Relative Humidity');
                    $this->SetValue($ident(8), $obs[8]);
                    $this->RegisterVariableInteger($ident(9), 'Illuminance');
                    $this->SetValue($ident(9), $obs[9]);
                    $this->RegisterVariableFloat($ident(10), 'UV Index');
                    $this->SetValue($ident(10), $obs[10]);
                    $this->RegisterVariableInteger($ident(11), 'Solar Radiation');
                    $this->SetValue($ident(11), $obs[11]);
                    $this->RegisterVariableFloat($ident(12), 'Precip Accumulated');
                    $this->SetValue($ident(12), $obs[12]);
                    $this->RegisterVariableInteger($ident(13), 'Precipitation Type');
                    $this->SetValue($ident(13), $obs[13]);
                    $this->RegisterVariableInteger($ident(14), 'Lightning Strike Avg Distance');
                    $this->SetValue($ident(14), $obs[14]);
                    $this->RegisterVariableInteger($ident(15), 'Lightning Strike Count');
                    $this->SetValue($ident(15), $obs[15]);
                    $this->RegisterVariableFloat($ident(16), 'Battery');
                    $this->SetValue($ident(16), $obs[16]);
                    $this->RegisterVariableInteger($ident(17), 'Report Interval');
                    $this->SetValue($ident(17), $obs[17]);
                }
                break;
            default:
                $this->SendDebug('Unsupported Type', $data['type'], 0 /* Text */);
                break;
        }
    }
}