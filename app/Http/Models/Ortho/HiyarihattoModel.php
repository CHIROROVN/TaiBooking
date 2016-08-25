<?php namespace App\Http\Models\Ortho;

class HiyarihattoModel
{
    public function Rules()
    {
        return array(
                    'year'                      => 'required',
                    'month'                     => 'required',
                    'day'                       => 'required',
                    'hour'                      => 'required',
                    'place'                     => 'required',
                    'age'                       => 'numeric',
                    'discoverer'                => 'required',
                    //4
                    'dentist'                   => 'required',
                    'hygienist'                 => 'required',
                    'technician'                => 'required',
                    'nurse'                     => 'required',
                    'secretary'                 => 'required',
                    'other_cb'                  => 'required',
                    'other_input_job'           => 'required',
                    //5
                    'scene'                     => 'required',
                    //6
                    'contents'                  => 'required',
                    //7
                    'party'                     => 'required',
                    'confirm'                   => 'required',
                    'observation'               => 'required',
                    'judgment'                  => 'required',
                    'knowledge'                 => 'required',
                    'technology'                => 'required',
                    'corners'                   => 'required',
                    'occurrence'                => 'required',

                    'affect_env'                => 'required',
                    'contact'                   => 'required',
                    'transmission'              => 'required',
                    'manual'                    => 'required',
                    'cooperation'               => 'required',
                    'mistake'                   => 'required',
                    'misreading'                => 'required',
                    'affect_text'               => 'required',

                    'medical_device'            => 'required',
                    'defect'                    => 'required',
                    'fault'                     => 'required',
                    'handle'                    => 'required',
                    'placement'                 => 'required',
                    'quantity'                  => 'required',
                    'inappropriate'             => 'required',
                    'malfunction'               => 'required',
                    'medical_error'             => 'required',
                    'medical_text'              => 'required',

                    'education'                 => 'required',
                    'edu_training'              => 'required',
                    'explan_patient'            => 'required',
                    'understand_patient'        => 'required',
                    'edu_text'                  => 'required',

                    'other_chk'                 => 'required',
                    'other'                     => 'required',
                    //8
                    'impact'                    => 'required',
                    'impact_affect'             => 'required',
        );
    }

    public function Messages()
    {
        return array(
                'year.required'                 => trans('validation.error_year_required'),
                'month.required'                => trans('validation.error_month_required'),
                'day.required'                  => trans('validation.error_day_required'),
                'hour.required'                 => trans('validation.error_hour_required'),
                'place.required'                => trans('validation.error_place_required'),
                'age.numeric'                   => trans('validation.error_age_required'),
                'discoverer.required'           => trans('validation.error_discoverer_required'),
                //4
                'dentist.required'              => trans('validation.error_dentist_required'),
                'hygienist.required'            => trans('validation.error_hygienist_required'),
                'technician.required'           => trans('validation.error_technician_required'),
                'nurse.required'                => trans('validation.error_nurse_required'),
                'secretary.required'            => trans('validation.error_secretary_required'),
                'other_cb.required'             => trans('validation.error_other_cb_required'),
                'other_input_job.required'      => trans('validation.error_other_input_job_required'),
                //5
                'scene.required'                => trans('validation.error_scene_required'),
                //6
                'contents.required'             => trans('validation.error_contents_required'),
                //7.1
                'party.required'                => trans('validation.error_party_required'),
                'confirm.required'              => trans('validation.error_confirm_required'),
                'observation.required'          => trans('validation.error_observation_required'),
                'judgment.required'             => trans('validation.error_judgment_required'),
                'knowledge.required'            => trans('validation.error_knowledge_required'),
                'technology.required'           => trans('validation.error_technology_required'),
                'corners.required'              => trans('validation.error_corners_required'),
                'occurrence.required'           => trans('validation.error_occurrence_required'),
                //7.2
                'affect_env.required'           => trans('validation.error_affect_env_required'),
                'contact.required'              => trans('validation.error_contact_required'),
                'transmission.required'         => trans('validation.error_transmission_required'),
                'manual.required'               => trans('validation.error_manual_required'),
                'cooperation.required'          => trans('validation.error_cooperation_required'),
                'mistake.required'              => trans('validation.error_mistake_required'),
                'misreading.required'           => trans('validation.error_misreading_required'),
                'affect_text.required'          => trans('validation.error_affect_text_required'),
                //7.3
                'medical_device.required'       => trans('validation.error_medical_device_required'),
                'defect.required'               => trans('validation.error_defect_required'),
                'fault.required'                => trans('validation.error_fault_required'),
                'handle.required'               => trans('validation.error_handle_required'),
                'placement.required'            => trans('validation.error_placement_required'),
                'quantity.required'             => trans('validation.error_quantity_required'),
                'inappropriate.required'        => trans('validation.error_inappropriate_required'),
                'malfunction.required'          => trans('validation.error_malfunction_required'),
                'medical_error.required'        => trans('validation.error_medical_error_required'),
                'medical_text.required'         => trans('validation.error_medical_text_required'),
                //7.4
                'education.required'            => trans('validation.error_education_required'),
                'edu_training.required'         => trans('validation.error_edu_training_required'),
                'explan_patient.required'       => trans('validation.error_explan_patient_required'),
                'understand_patient.required'   => trans('validation.error_understand_patient_required'),
                'edu_text.required'             => trans('validation.error_edu_text_required'),
                'other_chk.required'            => trans('validation.error_other_chk_required'),
                'other.required'                => trans('validation.error_other_required'),

                'impact.required'               => trans('validation.error_impact_required'),
                'impact_affect.required'        => trans('validation.error_impact_affect_required'),
        );
    }


}