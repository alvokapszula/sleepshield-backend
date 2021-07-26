<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Exam;
use App\Patient;
use App\Shield;
use App\Sensor;
use App\User;

class DataTablesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function exams(Datatables $datatables)
    {
        return datatables()->of(Exam::all())
        ->addColumn('patient', function($exam) {
            return '<a href="/patients/'.$exam->patient->id.'">' . $exam->patient->fullname() . '</a>';
        })
        ->addColumn('img', function($exam) {
            return '<a href="/patients/'.$exam->patient->id.'"><img src="'.asset($exam->patient->image).'" style="max-height:70px;max-width:70px;"/></a>';
        })
        ->addColumn('shield', function($exam) {
            return '<a href="/shields/'.$exam->shield->id.'">' . $exam->shield->uid . '</a>';
        })
        ->addColumn('user', function($exam) {
            return '<a href="/users/'.$exam->user->id.'">' . $exam->user->name . '</a>';
        })
        ->addColumn('actions', function($exam) {
            $ret = '<a href="/exams/'.$exam->id.'/edit"><i class="material-icons" title="'.__('datatables.edit').'">edit</i></a>
                <a href="/exams/'.$exam->id.'"><i class="material-icons" title="'.__('datatables.details').'">details</i></a>';
            if ($exam->is_running) {
                $ret .= '<a href="/exams/'.$exam->id.'/stop" class="text-danger"><i class="material-icons" title="'.__('datatables.stop').'">stop</i></a>';
            }
            if ($exam->havent_started) {
                $ret .= '<a href="/exams/'.$exam->id.'/start" class="text-success"><i class="material-icons" title="'.__('datatables.start').'">play_arrow</i></a>';
            }
            return $ret;
        })
        ->rawColumns(['patient', 'shield', 'user', 'actions', 'img'])
        ->setRowClass(function ($exam) {
            return ($exam->is_running ? 'bg-warning text-white' : '');
        })
        ->toJson();
    }

    public function patients(Datatables $datatables)
    {
        return datatables()->of(Patient::all())
        ->addColumn('actions', function($patient) {
            return '<a href="/patients/'.$patient->id.'/edit"><i class="material-icons" title="'.__('datatables.edit').'">edit</i></a>
                <a href="/patients/'.$patient->id.'"><i class="material-icons" title="'.__('datatables.details').'">details</i></a>';
        })
        ->addColumn('img', function($patient) {
            return '<a href="/patients/'.$patient->id.'"><img src="'.asset($patient->image).'" style="max-height:70px;max-width:70px;"/></a>';
        })
        ->editColumn('height', function ($patient) {
            return $patient->height." cm";
        })
        ->editColumn('weight', function ($patient) {
            return $patient->weight." kg";
        })
        ->rawColumns(['actions', 'img'])
        ->toJson();
    }

    public function patients_exams(Datatables $datatables, Patient $patient)
    {
        // dd(Exam::where('patient_id','=',$patient->id)->get());
        return datatables()->of(Exam::where('patient_id','=',$patient->id)->get())
        ->addColumn('shield', function($exam) {
            return '<a href="/shields/'.$exam->shield->id.'">' . $exam->shield->uid . '</a>';
        })
        ->addColumn('user', function($exam) {
            return '<a href="/users/'.$exam->user->id.'">' . $exam->user->name . '</a>';
        })
        ->addColumn('actions', function($exam) {
            $ret = '<a href="/exams/'.$exam->id.'/edit"><i class="material-icons" title="'.__('datatables.edit').'">edit</i></a>
                <a href="/exams/'.$exam->id.'"><i class="material-icons" title="'.__('datatables.details').'">details</i></a>';
            if ($exam->is_running) {
                $ret .= '<a href="/exams/'.$exam->id.'/stop" class="text-danger"><i class="material-icons" title="'.__('datatables.stop').'">stop</i></a>';
            }
            if ($exam->havent_started) {
                $ret .= '<a href="/exams/'.$exam->id.'/start" class="text-success"><i class="material-icons" title="'.__('datatables.start').'">play_arrow</i></a>';
            }
            return $ret;
        })
        ->rawColumns(['shield', 'user', 'actions'])
        ->setRowClass(function ($exam) {
            return ($exam->is_running ? 'bg-warning text-white' : '');
        })
        ->toJson();
    }

    public function users_exams(Datatables $datatables, User $user)
    {
        // dd(Exam::where('user_id','=',$user->id)->get());
        return datatables()->of(Exam::where('user_id','=',$user->id)->get())
        ->addColumn('shield', function($exam) {
            return '<a href="/shields/'.$exam->shield->id.'">' . $exam->shield->uid . '</a>';
        })
        ->addColumn('patient', function($exam) {
            return '<a href="/patients/'.$exam->patient->id.'">' . $exam->patient->fullname() . '</a>';
        })
        ->addColumn('actions', function($exam) {
            $ret = '<a href="/exams/'.$exam->id.'/edit"><i class="material-icons" title="'.__('datatables.edit').'">edit</i></a>
                <a href="/exams/'.$exam->id.'"><i class="material-icons" title="'.__('datatables.details').'">details</i></a>';
            if ($exam->is_running) {
                $ret .= '<a href="/exams/'.$exam->id.'/stop" class="text-danger"><i class="material-icons" title="'.__('datatables.stop').'">stop</i></a>';
            }
            if ($exam->havent_started) {
                $ret .= '<a href="/exams/'.$exam->id.'/start" class="text-success"><i class="material-icons" title="'.__('datatables.start').'">play_arrow</i></a>';
            }
            return $ret;
        })
        ->rawColumns(['shield', 'patient', 'actions'])
        ->setRowClass(function ($exam) {
            return ($exam->is_running ? 'bg-warning text-white' : '');
        })
        ->toJson();
    }

    public function shields(Datatables $datatables)
    {
        return datatables()->of(Shield::all())
        ->addColumn('actions', function($shield) {
            return '<a href="/shields/'.$shield->id.'/edit"><i class="material-icons" title="'.__('datatables.edit').'">edit</i></a>
                <a href="/shields/'.$shield->id.'"><i class="material-icons" title="'.__('datatables.details').'">details</i></a>';
        })
        ->addcolumn('img', function($shield) {
            return '<img src="'.asset('img/shield.png').'" style="max-height:70px;max-width:70px;">';
        })
        ->rawColumns(['img', 'actions'])
        ->toJson();
    }

    public function shield_exams(Datatables $datatables, Shield $shield)
    {
        // dd(Exam::where('shield_id','=',$shield->id)->get());
        return datatables()->of(Exam::where('shield_id','=',$shield->id)->get())
        ->addColumn('patient', function($exam) {
            return '<a href="/patients/'.$exam->patient->id.'">' . $exam->patient->fullname() . '</a>';
        })
        ->addColumn('user', function($exam) {
            return '<a href="/users/'.$exam->user->id.'">' . $exam->user->name . '</a>';
        })
        ->addColumn('actions', function($exam) {
            $ret = '<a href="/exams/'.$exam->id.'/edit"><i class="material-icons" title="'.__('datatables.edit').'">edit</i></a>
                <a href="/exams/'.$exam->id.'"><i class="material-icons" title="'.__('datatables.details').'">details</i></a>';
            if ($exam->is_running) {
                $ret .= '<a href="/exams/'.$exam->id.'/stop" class="text-danger"><i class="material-icons" title="'.__('datatables.stop').'">stop</i></a>';
            }
            if ($exam->havent_started) {
                $ret .= '<a href="/exams/'.$exam->id.'/start" class="text-success"><i class="material-icons" title="'.__('datatables.start').'">play_arrow</i></a>';
            }
            return $ret;
        })
        ->rawColumns(['patient', 'user', 'actions'])
        ->setRowClass(function ($exam) {
            return ($exam->is_running ? 'bg-warning text-white' : '');
        })
        ->toJson();
    }

    public function shield_sensors(Datatables $datatables, Shield $shield)
    {
        return datatables()->of(Sensor::where('shield_id','=',$shield->id)->get())
        ->toJson();
    }

	/**
     * Process dataTable ajax response.
     *
     * @param \Yajra\Datatables\Datatables $datatables
     * @return \Illuminate\Http\JsonResponse
     */
     // FIXME
    // public function playersIndex(Datatables $datatables)
    // {
    //
    //     // return $datatables->collection(\App\Player::all())
	// 	return $datatables->eloquent(\App\Player::with('team')->select('players.*'))
	// 		->editColumn('fstart_number', function ($player) {
	// 			return $player->fstart_number();
	// 		})
	// 		->addColumn('fullname', function ($player) {
	// 			return '<a href="/players/'.$player->id.'">' . $player->fname() . '</a>';
	// 		})
	// 		->addColumn('team', function($player) {
	// 			return '<a href="/teams/'.$player->team->id.'">' . $player->team->name . '</a>';
	// 		})
	// 		->addColumn('registration', function($player) {
	// 			return '<a href="/registrations/'.$player->registration->id.'">részletek</a>';
	// 		})
	// 		->addColumn('paid', function($player) {
	// 			return view('datatables.players.paid', compact('player'))->render();
	// 		})
	// 		->rawColumns(['fullname', 'team', 'registration', 'paid'])
	// 		->filterColumn('fullname', function($query, $keyword) {
	// 			$sql = "CONCAT(players.firstname,'-',players.lastname,'-',players.email)  like ?";
	// 			$query->whereRaw($sql, ["%{$keyword}%"]);
	// 		})
	// 		->filterColumn('fstart_number', function($query, $keyword) {
	// 			$sql = "players.start_number like ?";
	// 			$query->whereRaw($sql, ["%{$keyword}%"]);
	// 		})
	// 		->addColumn('fee', function($player) {
	// 			return $player->fee().' ('.$player->st_fee.')';
	// 		})
	// 		->orderColumn('fee', 'st_fee $1')
	// 		->orderColumn('fullname', 'lastname $1')
	// 		->orderColumn('team', 'team.name $1')
	// 		->orderColumn('fstart_number', 'start_number $1')
	// 		->orderColumn('arrived_at', 'email.arrived_at $1')
	// 		->make(true);
    // }

}
