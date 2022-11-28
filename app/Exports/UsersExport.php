<?php
namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\SearchTerm;
class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
    public function collection()
    {
        $now = strtotime('tomorrow');
        $ago_time =time();
       
           
                if($this->id=='today'){
                    $visitors = User::select('id','role_id','name','email','status','image','created_at')->where('role_id','!=',1)->whereBetween('created_at',[strtotime('today'),time()])->get();
                   
                }
                if($this->id=='weekly'){
                   
                    $visitors = User::select('id','name','role_id','email','status','image','created_at')->where('role_id','!=',1)->whereBetween('created_at',[strtotime('last sunday midnight'),time()])->get();
                }
                if($this->id=='monthly'){
                    $this_month = strtotime(date('y-m-1'));
                    $visitors = User::select('id','name','role_id','email','status','image','created_at')->where('role_id','!=',1)->whereBetween('created_at',[ $this_month ,time()])->get();

                   
                }
                if($this->id=='yearly'){
                    $this_month = strtotime(date('y-1-1'));
                    $visitors = User::select('id','name','role_id','email','status','image','created_at')->where('role_id','!=',1)->whereBetween('created_at',[ $this_month ,time()])->get();
                }
  
                if($this->id=='logins_today'){
                    $visitors = User::select('id','role_id','name','email','status','image','created_at')->where('role_id','!=',1)->whereBetween('updated_at',[strtotime('today'),time()])->get();
                   
                }
                if($this->id=='logins_weekly'){
                   
                    $visitors = User::select('id','name','role_id','email','status','image','created_at')->where('role_id','!=',1)->whereBetween('updated_at',[strtotime('last sunday midnight'),time()])->get();
                }
                if($this->id=='logins_monthly'){
                    $this_month = strtotime(date('y-m-1'));
                    $visitors = User::select('id','name','role_id','email','status','image','created_at')->where('role_id','!=',1)->whereBetween('updated_at',[ $this_month ,time()])->get();
                }
                if($this->id=='search_terms'){
                    $visitors =  SearchTerm::orderBy('created_at','asc')->get()
                    ;
                }if($this->id==1 || $this->id==2 || $this->id ==3 || $this->id ==4 || $this->id ==5 || $this->id ==6 || $this->id == 7 || $this->id ==8 || $this->id==9 || $this->id ==10 || $this->id == 11 || $this->id ==12){
                    $this_month = strtotime(date('01-'.$this->id.'-Y'));
    
                if($this->id =='1' || $this->id =='3' || $this->id=='5'|| $this->id=='7' || $this->id =='8' ||$this->id=='10' || $this->id =='12'){
                    $this_month_end = strtotime(date('31-'.$this->id.'-Y'));}
                    if($this->id =='2'){
                        $this_month_end = strtotime(date('28-'.$this->id.'-Y'));}
       
                    else{
                        $this_month_end = strtotime(date('30-'.$this->id.'-Y'));}
                        $visitors = User::select('id','name','role_id','email','status','image','created_at')->whereIn('role_id',[2,3])->whereBetween('created_at',[ $this_month ,$this_month_end])->get();

            }
        return $visitors;
    }
    
    public function map($visitors): array
    { 
        if($this->id == 'search_terms'){
            return [ $visitors->term,
            $visitors->no_of_times_searched];
        }else{
        if($visitors->status==0){
            $status='Unverified';
        }
        if($visitors->status==1){
            $status='Active';
        }else{
            $visitors='-';
        }
        if($visitors->role_id == 2){
            $role=$visitors->role_id;
        }else{
            $role=$visitors->role_id;
        }

        
        return [
             $visitors->name,
             $role,
             $visitors->email,
           $status,
            date('y/m/d',$visitors->created_at),
                
        ];
    
}

}

    public function headings(): array
    {
        if($this->id == 'search_terms'){
            return [  'Search Term','no_of_times_searched'];

        }else{
        return [
            'Name','Role','Email','Status','Joined Date'
        ];
    }
    }
}