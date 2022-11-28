<?php
namespace App\Exports;

use App\Models\BookedLesson;
use App\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LoginsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    // Fetch daily,weekly and monthly logins
    public function collection()
    {
        $now = strtotime('tomorrow');
        $ago_time = time();

        if ($this->id == 'today') {
            $visitors = User::select('id', 'role_id', 'name', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time', 'last_login')->where('status',1)->where('role_id', '!=', 1)->whereBetween('updated_at', [strtotime('today'), time()])->get();

        }
        if ($this->id == 'weekly') {

            $visitors = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time', 'last_login')->where('status',1)->where('role_id', '!=', 1)->whereBetween('updated_at', [strtotime('last sunday midnight'), time()])->get();
        }
        if ($this->id == 'monthly') {
            $this_month = strtotime(date('y-m-1'));
            $visitors = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time', 'last_login')->where('status',1)->where('role_id', '!=', 1)->whereBetween('updated_at', [$this_month, time()])->get();

        }
        if ($this->id == 'yearly') {
            $this_month = strtotime(date('y-1-1'));
            $visitors = User::select('id', 'name', 'role_id', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time', 'last_login')->where('status',1)->where('role_id', '!=', 1)->whereBetween('updated_at', [$this_month, time()])->get();
        }if($this->id==1 || $this->id==2 || $this->id ==3 || $this->id ==4 || $this->id ==5 || $this->id ==6 || $this->id == 7 || $this->id ==8 || $this->id==9 || $this->id ==10 || $this->id == 11 || $this->id ==12){
            $this_month = strtotime(date('01-'.$this->id.'-Y'));

            if($this->id =='1' || $this->id =='3' || $this->id=='5'|| $this->id=='7' || $this->id =='8' ||$this->id=='10' || $this->id =='12'){
                $this_month_end = strtotime(date('31-'.$this->id.'-Y'));}
                if($this->id =='2'){
                    $this_month_end = strtotime(date('28-'.$this->id.'-Y'));}
   
                else{
                    $this_month_end = strtotime(date('30-'.$this->id.'-Y'));}
                    $visitors = User::select('id', 'name', 'role_id', 'gender', 'email', 'status', 'image', 'created_at', 'updated_at', 'average_time', 'last_login')->with('userinterests.interests')->where('status',1)->where('role_id', '!=', 1)->whereBetween('updated_at', [$this_month,$this_month_end])->get();
    
        }

        return $visitors;
    }

    public function map($visitors): array
    {
        if ($visitors->status == 0) {
            $status = 'Unverified';
        }
        if ($visitors->status == 1) {
            $status = 'Active';
        } else {
            $visitors = '-';
        }
        if ($visitors->role_id == 2) {
            $role = 'Host';
        }
        if ($visitors->role_id == 3) {
            $role = 'User';
        } else {
            $role = 'Host';
        }

        $report_array[] = array(

        );
        if ($visitors->average_time < 60) {
            $time = $visitors->average_time . ' seconds';
        } else {
            $time = round($visitors->average_time / 60, 2) . 'minutes';

        }
        // $booked_lessons = BookedLesson::where('student_id', $visitors->id)->orWhere('teacher_id', $visitors->id)->where('status', 3)->sum('duration');
        return [
            $visitors->name,
            $role,
            $visitors->email,
            $status,
            date('y/m/d', $visitors->created_at),
            gmdate("H:i:s", $visitors->average_time),
            date('y/m/d', $visitors->updated_at),

        ];
    }

    public function headings(): array
    {
        return [
            'Name', 'Role', 'Email', 'Status', 'Joined Date', 'Average time spent on the website', 'Last Login',
        ];
    }
    //duration_hour
}
