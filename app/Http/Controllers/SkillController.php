<?php

namespace App\Http\Controllers;

use App\skill;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Auth;

class SkillController extends Controller
{   
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return skill::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->bg_image) {
            // Get image file
            $image = $request->bg_image;
            // Make a image name based on user name and current timestamp
            $name = 'skill'.'_'.time();
            // Define folder path
            $folder = '/uploads/images/skills/bg_images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image,$folder,'public', $name);
        }
        
        $skill = new Skill;

        $skill->skill = $request->skill;
        $skill->keterangan = $request->keterangan;
        $skill->bg_image = $filePath;
        $skill->icon = "icon";
        $skill->save();

        return response()->json(['Messages' => 'New skill was successfully created!']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->bg_image) {
            // Get image file
            $image = $request->bg_image;
            // Make a image name based on user name and current timestamp
            $name = str_slug($request->role).'_'.time();
            // Define folder path
            $folder = '/uploads/images/roles/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image,$folder,'public', $name);
        }

        $skill = Skill::find($id);
        $skill->skill = $request->skill;
        $skill->keterangan = $request->keterangan;
        $skill->bg_image = $filePath;
        $skill->update();

        return response()->json(['Messages'=> 'Successfully updating the skill']);
    }

    public function delete($id)
    {
        $skill = Skill::find($id);
        
        $skill->delete();

        return response()->json(['Messages'=> 'Successfully deleting the skill']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(skill $skill)
    {
        //
    }
}
