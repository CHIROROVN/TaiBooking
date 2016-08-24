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
                    'discoverer'                => 'required',
                    'dentist'                   => 'required',
                    'hygienist'                 => 'required',
                    'technician'                => 'required',
                    'nurse'                     => 'required',
                    'secretary'                 => 'required',
                    'other_input'               => 'required',
                    'scene'                     => 'required',
                    'contents'                  => 'required',
                    'party'                     => 'required',
                    'confirm'                   => 'required',
                    'observation'               => 'required',
                    'judgment'                  => 'required',
                    'knowledge'                 => 'required',
                    'technology'                => 'required',
                    'corners'                   => 'required',
                    'occurrence'                => 'required',
                    'impact'                    => 'required',

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
                'discoverer.required'           => trans('validation.error_discoverer_required'),
                'dentist.required'              => trans('validation.error_dentist_required'),
                'hygienist.required'            => trans('validation.error_hygienist_required'),
                'technician.required'           => trans('validation.error_technician_required'),
                'nurse.required'                => trans('validation.error_nurse_required'),
                'secretary.required'            => trans('validation.error_secretary_required'),
                'other_input.required'          => trans('validation.error_other_input_required'),
                'scene.required'                => trans('validation.error_scene_required'),
                'contents.required'             => trans('validation.error_contents_required'),
                'party.required'                => trans('validation.error_party_required'),
                'confirm.required'              => trans('validation.error_confirm_required'),
                'observation.required'          => trans('validation.error_observation_required'),
                'judgment.required'             => trans('validation.error_judgment_required'),
                'knowledge.required'            => trans('validation.error_knowledge_required'),
                'technology.required'           => trans('validation.error_technology_required'),
                'corners.required'              => trans('validation.error_corners_required'),
                'occurrence.required'           => trans('validation.error_occurrence_required'),
                'impact.required'               => trans('validation.error_impact_required'),
        );
    }


}