<?php
namespace App\Exports;

use App\Models\BookedLesson;
use App\Models\Category;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */

    // Fetch daily,weekly and montly classes report
    public function __construct(string $id)
    {
        $this->id = $id;
    }
    public function collection()
    {
        $now = strtotime('tomorrow');
        $ago_time = time();

        if ($this->id == 'today') {
            $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->whereHas('lessons', function ($q) use ($ago_time, $now) {
                $q->whereBetween('from_timing', [strtotime('today'), time()]);})->orderBy('created_at', 'desc')->get();
        }
        if ($this->id == 'weekly') {
            $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->whereHas('lessons', function ($q) use ($ago_time, $now) {
                $q->whereBetween('from_timing', [strtotime('last sunday midnight'), time()]);})->orderBy('created_at', 'desc')->get();
        }
        if ($this->id == 'monthly') {
            $this_month = strtotime(date('01-m-Y'));
            $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag',1)->whereHas('lessons', function ($q) use ($this_month) {
                $q->whereBetween('from_timing', [$this_month, time()]);})->orderBy('created_at', 'desc')->get();
        }
        if ($this->id == 'booked_today') {
            $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->whereBetween('from_timing', [strtotime('today'), time()])->where('status', 1)->orderBy('created_at', 'desc')->get();
        }
        if ($this->id == 'booked_weekly') {
            $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->where('status', 1)->whereBetween('from_timing', [strtotime('last sunday midnight'), time()])->orderBy('created_at', 'desc')->get();
        }
        if ($this->id == 'booked_monthly') {
            $this_month = strtotime(date('01-m-y'));
            $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->where('status', 1)->whereBetween('from_timing', [$this_month, time()])->orderBy('created_at', 'desc')->get();
        }
        if ($this->id == 'hosted_today') {
            $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->whereBetween('from_timing', [strtotime('today'), time()])->where('status', 3)->orderBy('created_at', 'desc')->get();
        }
        if ($this->id == 'hosted_weekly') {
            $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->where('status', 3)->whereBetween('from_timing', [strtotime('last sunday midnight'), time()])->orderBy('created_at', 'desc')->get();
        }
        if ($this->id == 'hosted_monthly') {
            $this_month = strtotime(date('01-m-Y'));
            $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag', 1)->where('status', 3)->whereBetween('from_timing', [$this_month, time()])->orderBy('created_at', 'desc')->get();
        }if($this->id==1 || $this->id==2 || $this->id ==3 || $this->id ==4 || $this->id ==5 || $this->id ==6 || $this->id == 7 || $this->id ==8 || $this->id==9 || $this->id ==10 || $this->id == 11 || $this->id ==12){
                $this_month = strtotime(date('01-'.$this->id.'-Y'));

            if($this->id =='1' || $this->id =='3' || $this->id=='5'|| $this->id=='7' || $this->id =='8' ||$this->id=='10' || $this->id =='12'){
                $this_month_end = strtotime(date('31-'.$this->id.'-Y'));}
                if($this->id =='2'){
                    $this_month_end = strtotime(date('28-'.$this->id.'-Y'));}
   
                else{
                    $this_month_end = strtotime(date('30-'.$this->id.'-Y 23:59:59'));}
                    $today_schedule = BookedLesson::with(['lessons', 'user', 'teacher'])->where('payment_flag',1)->whereHas('lessons', function ($q) use ($this_month, $this_month_end) {
                        $q->whereBetween('from_timing', [$this_month,$this_month_end]);})->orderBy('created_at', 'desc')->get();
        }

        return $today_schedule;
    }

    public function map($today_schedule): array
    {
        $category_id = Subject::where('name', $today_schedule->lessons->subject_name)->first()->category_id;
        $category = Category::where('id', $category_id)->first()->title;

        if ($today_schedule->lessons->type == 1) {
            $type = 'Face To Face';
        } else {
            $type = 'Online';

        }

        return [
            $category,
            $today_schedule->subject_name,
            $today_schedule->class_name,
            isset($today_schedule->teacher->name) ? $today_schedule->teacher->name : 'Matutto Host',
            isset($today_schedule->user->name) ? $today_schedule->user->name : 'Matutto User',
            $today_schedule->cost,
            $today_schedule->currency,

            $type,
            Date('y-m-d', $today_schedule->from_timing),
            Date('h:i A', $today_schedule->from_timing),
            $today_schedule->status,
            ($today_schedule->duration_hour*60*60+ $today_schedule->duration_minutes*60)/60,

        ];
    }

    public function headings(): array
    {
        return [
            'Class Category', 'Class Subject', 'Class Name', 'Host Name', 'User Name', 'Class Price', 'Currency', 'Class Type', 'Class Date', 'Class Time', 'Status', 'duration',
        ];
    }
}
