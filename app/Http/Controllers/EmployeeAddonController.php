<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeAddonController extends Controller
{
    /**
     * Store or Update Qualification
     */
    public function saveQualification(Request $request)
    {
        $id = $request->input('qualification_id');
        $data = [
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'education_level_id' => $request->education_level_id,
            'from_year' => $request->from_year,
            'to_year' => $request->to_year,
            'language_id' => $request->language_id ?? 0,
            'specialization' => $request->specialization ?? '',
            'description' => $request->description ?? '',
            'skill_id' => $request->skill_id ?? '',
            'updated_at' => Carbon::now(),
        ];

        if ($id) {
            DB::table('employee_qualification')->where('qualification_id', $id)->update($data);
            return response()->json(['success' => 'Qualification updated successfully.']);
        } else {
            $data['created_at'] = Carbon::now();
            DB::table('employee_qualification')->insert($data);
            return response()->json(['success' => 'Qualification added successfully.']);
        }
    }

    public function deleteQualification($id)
    {
        DB::table('employee_qualification')->where('qualification_id', $id)->delete();
        return response()->json(['success' => 'Qualification removed.']);
    }

    /**
     * Store or Update Work Experience
     */
    public function saveExperience(Request $request)
    {
        $id = $request->input('work_experience_id');
        $data = [
            'employee_id' => $request->employee_id,
            'company_name' => $request->company_name,
            'post' => $request->post,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'description' => $request->description ?? '',
            'updated_at' => Carbon::now(),
        ];

        if ($id) {
            DB::table('employee_work_experience')->where('work_experience_id', $id)->update($data);
            return response()->json(['success' => 'Experience updated successfully.']);
        } else {
            $data['created_at'] = Carbon::now();
            DB::table('employee_work_experience')->insert($data);
            return response()->json(['success' => 'Experience added successfully.']);
        }
    }

    public function deleteExperience($id)
    {
        DB::table('employee_work_experience')->where('work_experience_id', $id)->delete();
        return response()->json(['success' => 'Experience removed.']);
    }

    /**
     * Store or Update Emergency Contact
     */
    public function saveContact(Request $request)
    {
        $id = $request->input('contact_id');
        $data = [
            'employee_id' => $request->employee_id,
            'contact_name' => $request->contact_name,
            'relation' => $request->relation,
            'mobile_phone' => $request->mobile_phone,
            'personal_email' => $request->personal_email ?? '',
            'is_primary' => $request->is_primary ?? 0,
            'is_dependent' => $request->is_dependent ?? 0,
            'work_phone' => $request->work_phone ?? '',
            'work_phone_extension' => $request->work_phone_extension ?? '',
            'home_phone' => $request->home_phone ?? '',
            'work_email' => $request->work_email ?? '',
            'address_1' => $request->address_1 ?? '',
            'address_2' => $request->address_2 ?? '',
            'city' => $request->city ?? '',
            'state' => $request->state ?? '',
            'zipcode' => $request->zipcode ?? '',
            'country' => $request->country ?? '',
            'updated_at' => Carbon::now(),
        ];

        if ($id) {
            DB::table('employee_contacts')->where('contact_id', $id)->update($data);
            return response()->json(['success' => 'Contact updated successfully.']);
        } else {
            $data['created_at'] = Carbon::now();
            DB::table('employee_contacts')->insert($data);
            return response()->json(['success' => 'Contact added successfully.']);
        }
    }

    public function deleteContact($id)
    {
        DB::table('employee_contacts')->where('contact_id', $id)->delete();
        return response()->json(['success' => 'Contact removed.']);
    }
}
