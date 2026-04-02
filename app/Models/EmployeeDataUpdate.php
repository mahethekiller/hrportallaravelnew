<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeDataUpdate
 * 
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $email_personal
 * @property string $date_of_birth
 * @property string $date_of_birth_doc
 * @property string $gender
 * @property string $contact_no
 * @property string $mother_tongue
 * @property string $age
 * @property string $place_of_birth
 * @property string $blood_group
 * @property string $marital_status
 * @property string $pan_number
 * @property string $aadhar_no
 * @property string $category
 * @property string $address
 * @property string $address_com
 * @property int $added_by
 * @property string $added_date
 * @property int $updated_by
 * @property string $updated_date
 * @property string $facebook_link
 * @property string $twitter_link
 * @property string $blogger_link
 * @property string $linkdedin_link
 * @property string $google_plus_link
 * @property string $instagram_link
 * @property string $pinterest_link
 * @property string $youtube_link
 * @property string $father_name
 * @property string $father_mobile
 * @property string $father_gender
 * @property string $father_occupation
 * @property string $father_age
 * @property string $father_qualification
 * @property string $father_address
 * @property string $mother_name
 * @property string $mother_mobile
 * @property string $mother_gender
 * @property string $mother_occupation
 * @property string $mother_age
 * @property string $mother_qualification
 * @property string $mother_address
 * @property string $brother_name
 * @property string $brother_mobile
 * @property string $brother_gender
 * @property string $brother_occupation
 * @property string $brother_age
 * @property string $brother_qualification
 * @property string $brother_address
 * @property string $sister_name
 * @property string $sister_mobile
 * @property string $sister_gender
 * @property string $sister_occupation
 * @property string $sister_age
 * @property string $sister_qualification
 * @property string $sister_address
 * @property string $spouse_name
 * @property string $spouse_mobile
 * @property string $spouse_gender
 * @property string $spouse_occupation
 * @property string $spouse_age
 * @property string $spouse_qualification
 * @property string $spouse_address
 * @property string $child1_name
 * @property string $child1_mobile
 * @property string $child1_gender
 * @property string $child1_occupation
 * @property string $child1_age
 * @property string $child1_qualification
 * @property string $child1_address
 * @property string $child2_name
 * @property string $child2_mobile
 * @property string $child2_gender
 * @property string $child2_occupation
 * @property string $child2_age
 * @property string $child2_qualification
 * @property string $child2_address
 * @property string|null $emergency_contact_relation
 * @property string|null $emergency_contact_name
 * @property string|null $emergency_contact_gender
 * @property string|null $emergency_contact_mobile
 * @property string|null $emergency_contact_age
 * @property string|null $emergency_contact_occupation
 * @property string|null $emergency_contact_qualification
 * @property string|null $emergency_contact_address
 * @property string $official_contact_no
 * @property string $vehicle_type
 * @property string $city_temp
 * @property string $city
 * @property string $state_temp
 * @property string $state
 * @property string $pin_temp
 * @property string $pincode
 * @property string $health_ins_opted
 * @property string $pf_opted
 * @property string $vehicle_no
 * @property string $paytm_no
 * @property string $skype_id
 * @property int $acceptance
 * @property string $acceptance_name
 * @property string $acceptance_date
 * @property int $acceptance_basic
 * @property int $acceptance_father
 * @property int $acceptance_mother
 * @property int $acceptance_emer
 * @property int $acceptance_bro
 * @property int $acceptance_sis
 * @property int $acceptance_c1
 * @property int $acceptance_c2
 * @property int $acceptance_social
 * @property int $acceptance_spouse
 * @property int $emp_updated_dets
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeDataUpdate extends Model
{
	protected $table = 'employee_data_updates';

	protected $casts = [
		'user_id' => 'int',
		'added_by' => 'int',
		'updated_by' => 'int',
		'acceptance' => 'int',
		'acceptance_basic' => 'int',
		'acceptance_father' => 'int',
		'acceptance_mother' => 'int',
		'acceptance_emer' => 'int',
		'acceptance_bro' => 'int',
		'acceptance_sis' => 'int',
		'acceptance_c1' => 'int',
		'acceptance_c2' => 'int',
		'acceptance_social' => 'int',
		'acceptance_spouse' => 'int',
		'emp_updated_dets' => 'int'
	];

	protected $fillable = [
		'user_id',
		'first_name',
		'last_name',
		'email',
		'email_personal',
		'date_of_birth',
		'date_of_birth_doc',
		'gender',
		'contact_no',
		'mother_tongue',
		'age',
		'place_of_birth',
		'blood_group',
		'marital_status',
		'pan_number',
		'aadhar_no',
		'category',
		'address',
		'address_com',
		'added_by',
		'added_date',
		'updated_by',
		'updated_date',
		'facebook_link',
		'twitter_link',
		'blogger_link',
		'linkdedin_link',
		'google_plus_link',
		'instagram_link',
		'pinterest_link',
		'youtube_link',
		'father_name',
		'father_mobile',
		'father_gender',
		'father_occupation',
		'father_age',
		'father_qualification',
		'father_address',
		'mother_name',
		'mother_mobile',
		'mother_gender',
		'mother_occupation',
		'mother_age',
		'mother_qualification',
		'mother_address',
		'brother_name',
		'brother_mobile',
		'brother_gender',
		'brother_occupation',
		'brother_age',
		'brother_qualification',
		'brother_address',
		'sister_name',
		'sister_mobile',
		'sister_gender',
		'sister_occupation',
		'sister_age',
		'sister_qualification',
		'sister_address',
		'spouse_name',
		'spouse_mobile',
		'spouse_gender',
		'spouse_occupation',
		'spouse_age',
		'spouse_qualification',
		'spouse_address',
		'child1_name',
		'child1_mobile',
		'child1_gender',
		'child1_occupation',
		'child1_age',
		'child1_qualification',
		'child1_address',
		'child2_name',
		'child2_mobile',
		'child2_gender',
		'child2_occupation',
		'child2_age',
		'child2_qualification',
		'child2_address',
		'emergency_contact_relation',
		'emergency_contact_name',
		'emergency_contact_gender',
		'emergency_contact_mobile',
		'emergency_contact_age',
		'emergency_contact_occupation',
		'emergency_contact_qualification',
		'emergency_contact_address',
		'official_contact_no',
		'vehicle_type',
		'city_temp',
		'city',
		'state_temp',
		'state',
		'pin_temp',
		'pincode',
		'health_ins_opted',
		'pf_opted',
		'vehicle_no',
		'paytm_no',
		'skype_id',
		'acceptance',
		'acceptance_name',
		'acceptance_date',
		'acceptance_basic',
		'acceptance_father',
		'acceptance_mother',
		'acceptance_emer',
		'acceptance_bro',
		'acceptance_sis',
		'acceptance_c1',
		'acceptance_c2',
		'acceptance_social',
		'acceptance_spouse',
		'emp_updated_dets'
	];
}
