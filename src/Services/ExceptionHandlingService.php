<?php

namespace Spt\ExceptionHandling\Services;

use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

/**
 *
 */
class ExceptionHandlingService
{
    protected $config = [];

    /**
    *
    * For getting dates in which log files are available
    *
    * @return array $dates
    **/
    public function getLogFileDates()
    {
        $dates = [];
        $files = glob(storage_path('logs/laravel-*.log'));
        $files = array_reverse($files);
        foreach ($files as $path) {
            $fileName = basename($path);
            preg_match('/(?<=laravel-)(.*)(?=.log)/', $fileName, $dtMatch);
            $date = $dtMatch[0];
            array_push($dates, $date);
        }

        return $dates;
    }

    /**
    *
    * For getting logs from the file for specified date
    *
    * @return $data array
    */
    public function getLogs($request)
    {
        $this->config['from_date'] = $request->from_date ? $request->from_date : null;
        $this->config['to_date'] = $request->to_date ? $request->to_date : null;
        $this->config['filter'] = $request->filter ? $request->filter : null;
        $availableDates = $this->getLogFileDates();
        if (count($availableDates) == 0) {
            $data = [
                'success' => false,
                'message' => __('spt.No log available'),
                'logs' => [],
                'from_date' => date('d-m-Y')
            ];
        }
        $fromDate = $this->config['from_date'];
        if ($fromDate == null) {
            $fromDate = date('d-m-Y', strtotime('-7 day'));
        }
        $toDate = $this->config['to_date'];
        if ($toDate == null) {
            $toDate = date('d-m-Y');
        }
        $filterPeriod = CarbonPeriod::create($fromDate, $toDate);
        $filterDates = [];
        $logs = [];
        foreach ($filterPeriod as $date) {
            $configDate = $date->format('Y-m-d');
            $filterDates[] = $configDate;
            $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<message>.*)\s{(?<detail>.*)/m";
            $fileName = 'laravel-' . $configDate . '.log';
            if (in_array($configDate, $availableDates)) {
                $content = file_get_contents(storage_path('logs/' . $fileName));
                preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);
                foreach ($matches as $key => $match) {
                    if ($this->config['filter'] == 'All' || $this->config['filter'] == null) 
                    {
                        $logs[] = [
                            'date' => $configDate,
                            'timestamp' => $match['date'],
                            'env' => $match['env'],
                            'type' => $match['type'],
                            'message' => trim($match['message']),
                            'detail' => trim($match['detail'])
                        ];
                    } elseif ($match['type'] == $this->config['filter']) {
                        $logs[] = [
                            'date' => $configDate,
                            'timestamp' => $match['date'],
                            'env' => $match['env'],
                            'type' => $match['type'],
                            'message' => trim($match['message']),
                            'detail' => trim($match['detail'])
                        ];
                    }
                }
            }
        }
        if (count($logs) == 0) {
            return [
                'success' => false,
                'message' => __('spt.no_logs_available_with_selected_filter'),
                'logs' => [],
                'from_date' => $fromDate,
                'to_date' => $toDate,
            ];
        }

        return [
            'available_log_dates' => $availableDates,
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'logs' => array_reverse($logs),
            'dates' => $filterDates,
            'success' => true
        ];
    }

    /**
    *
    * Function for getting different types of exception levels
    *
    * @return array
    */

    public function getLevels()
    {
        return [
            'EMERGENCY' => ['color_code' => '#b71b1c', 'color' => 'dark-red'],
            'ALERT' => ['color_code' => '#d32f30', 'color' => 'dark-red'],
            'CRITICAL' => ['color_code' => '#f44437', 'color' => 'light-red'],
            'ERROR' => ['color_code' => '#fe5722', 'color' => 'orange'],
            'WARNING' => ['color_code' => '#ff9000', 'color' => 'yellow'],
            'NOTICE' => ['color_code' => '#4baf4f', 'color' => 'green'],
            'INFO' => ['color_code' => '#1976d3', 'color' => 'blue'],
            'DEBUG' => ['color_code' => '#90caf8', 'color' => 'light-blue'],
        ];
    } 

    /**
    * For preparing chart data including levels and count
    *
    * @return $chartData array
    */
    public function prepareChartData($logs)
    {
        $logs = collect($logs)->groupBy('date');
        $chartData = $dataSets = [];
        $levels = $this->getLevels();
        foreach ($levels as $type => $level) {
            $dataSets[] = [
                'label' => $type,
                'backgroundColor' => $level['color_code'],
                'color' => $level['color'],
            ];
        }
        foreach ($logs as $date => $log) {
            $counts = array_count_values($log->pluck('type')->toArray());
            foreach ($dataSets as $key => $dataSet) {
                if (isset($counts[$dataSet['label']])) {
                    $dataSets[$key]['data'][] = $counts[$dataSet['label']];
                } else {
                    $dataSets[$key]['data'][] = 0;
                }
            }
        }
        $chartData['dates'] = array_keys($logs->toArray());
        $chartData['data_sets'] = $dataSets;

        return $chartData;
    }
}
