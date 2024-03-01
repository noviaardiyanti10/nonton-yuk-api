<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoryMovieRequest;
use App\Http\Requests\VerifyMovieRequest;
use App\Models\Movie;
use App\Models\WatchHistory;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateInterval;
use DateTime;

class MovieController extends Controller
{
    public function list(Request $request){
        try {
            $movies = Movie::get();

            return response()->json([
                'status' => 'success',
                'data' => $movies
            ]);

        } catch (Exception $er) {
            return response()->json([
                'status'=> 'error',
                'messages' => $er->getMessage()
            ]);
        }
    }

    public function verifyRequirement(VerifyMovieRequest $request){
        try {
            $data = Movie::find($request->movie_id)->first();

            if(!isset($data->movie_id)){
                return response()->json([
                    'status'=> 'error',
                    'messages' => 'Movie not found'
                ]);
            }

            $user = auth()->user();
            $dob = $user->birth_date;

            $age = Carbon::parse($dob)->age;
            
            if($age >= $data->min_age_req){
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'movie_id' => $data->movie_id,
                        'user_id' => $user->id
                    ]
                ]);
            }

            return response()->json([
                'status'=> 'error',
                'messages' => 'Not fill minimum age requirement'
            ]);

        } catch (Exception $er) {
            return response()->json([
                'status'=> 'error',
                'messages' => $er->getMessage()
            ]);
        }
    }

    public function CreateHistory(HistoryMovieRequest $request){
        try {
            $data = Movie::find($request->movie_id)->first();

            if(!isset($data->movie_id)){
                return response()->json([
                    'status'=> 'error',
                    'messages' => 'Movie not found'
                ]);
            }

            $param = $request->all();
            $today =  date('Y-m-d');
            $datetime = new DateTime();
            $exp_date = $datetime->add(new DateInterval('P14D'))->format('Y-m-d');

            $wacthed = WatchHistory::history($param);

            if(!isset($wacthed->id) || $wacthed->expired_date < $today){
                WatchHistory::create([
                    'movie_id' => $request->movie_id,
                    'user_id' => $request->user_id,
                    'active_date' => $today,
                    'expired_date' => $exp_date,
                    'flag' => 1
                ]);
            } 

            return response()->json([
                'status'=> 'success',
                'messages' => 'Success add movie'
            ]);
           

        } catch (Exception $er) {
            return response()->json([
                'status'=> 'error',
                'messages' => $er->getMessage()
            ]);
        }
    }
}
