@extends('backend.ortho.ortho')

@section('content')
    {!! Form::open(array('route' => ['ortho.list1_list.edit', $list1->id], 'method' => 'post')) !!}
      <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>各種リスト表示　＞　「TEL待ちリスト」の表示</h3>
              <div class="table-responsive">
                <table class="table table-bordered">

                  <!-- clinic_id -->
                  <tr>
                    <td class="col-title"><label for="telephone">医院名 <span class="note_required">※</span></label></td>
                    <td>
                      <select name="clinic_id" id="clinic_id" class="form-control form-control--medium">
                        <option value="">▼選択</option>
                        @foreach($clinics as $clinic)
                          @if ( $list1->clinic_id == $clinic->clinic_id )
                          <option value="{{$clinic->clinic_id}}" selected >{{$clinic->clinic_name}}</option>
                          @else
                          <option value="{{$clinic->clinic_id}}" >{{$clinic->clinic_name}}</option>
                          @endif
                        @endforeach
                      </select>
                      <span class="error-input">@if ($errors->first('clinic_id')) ※{!! $errors->first('clinic_id') !!} @endif</span>
                    </td>
                  </tr>

                  <!-- patient_id -->
                  <tr>
                    <td class="col-title"><label for="telephone">患者名 <span class="note_required">※</span></label></td>
                    <td>
                      <input type="hidden" name="p_id" id="p_id" value="{{ $list1->patient_id }}">
                      @foreach ( $patients as $patient )
                        @if ( $patient->p_id == $list1->patient_id )
                        <input type="text" name="patient" id="patient" class="input-text-mid form-control" style="width: 250px; display: inline;" value="{{ $patient->p_no }} {{ $patient->p_name_f }} {{ $patient->p_name_g }} ({{ $patient->p_name_f_kana }} {{ $patient->p_name_g_kana }})">
                        @endif
                      @endforeach
                      <span class="error-input">@if ($errors->first('p_id')) ※{!! $errors->first('p_id') !!} @endif</span>
                    </td>
                  </tr>

                  <!-- telephone -->
                  <tr>
                    <td class="col-title"><label for="telephone">電話番号 <span class="note_required">※</span></label></td>
                    <td>
                      <input type="text" name="telephone" id="telephone " class="form-control" value="{{ $list1->telephone }}" />
                      <span class="error-input">@if ($errors->first('telephone')) ※{!! $errors->first('telephone') !!} @endif</span>
                    </td>
                  </tr>

                  <!-- free_text -->
                  <tr>
                    <td class="col-title"><label for="free_text">備考</label></td>
                    <td>
                      <input type="text" name="free_text" id="free_text" class="form-control" value="{{ $list1->free_text }}" />
                      <span class="error-input">@if ($errors->first('free_text')) ※{!! $errors->first('free_text') !!} @endif</span>
                    </td>
                  </tr>
                </table>
              </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="submit" name="save" value="登録する" class="btn btn-sm btn-page mar-right">
              <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button>
              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                    </div>
                    <div class="modal-body">
                      <p>{{ trans('common.modal_content_delete') }}</p>
                    </div>
                    <div class="modal-footer">
                      <a href="{{ route('ortho.list1_list.delete', [$list1->id]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal -->
            </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <a href="{{ route('ortho.list1_list.index') }}" class="btn btn-sm btn-page mar-right">登録済み地域一覧に戻る</a>
            </div>
          </div>
        </div>
      </section>
    {!! Form::close() !!}
@stop

@section('script')
  <script>
    $(document).ready(function(){
      $( "#patient" ).autocomplete({
        minLength: 0,
        // source: pamphlets,
        source: function(request, response){
            var key = $('#patient').val();
            $.ajax({
                url: "{{ route('ortho.patients.autocomplete.patient') }}",
                beforeSend: function(){
                },
                method: "GET",
                data: { key: key },
                dataType: "json",
                success: function(data) {
                  response(data);
                },
            });
        },
        focus: function( event, ui ) {
          $( "#patient" ).val( ui.item.label );
          return true;
        },
        select: function( event, ui ) {
          $( "#patient" ).val( ui.item.label );
          $( "#p_id" ).val( ui.item.value );
          return false;
        }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .append( "<a>" + item.desc + "</a>" )
            .appendTo( ul );
      };
    });
  </script>
@stop