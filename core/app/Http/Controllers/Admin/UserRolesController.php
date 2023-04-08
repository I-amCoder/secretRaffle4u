<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\SendSms;
use App\Models\GeneralSetting;
use App\Models\SmsTemplate;
use App\Models\UserRole;
use Illuminate\Http\Request;
use DB;

class UserRolesController extends Controller
{
    public function index()
    {
        $pageTitle = 'User Roles';
        $emptyMessage = 'No Users';
        $users = UserRole::get();
        return view('admin.user_roles.index', compact('pageTitle', 'emptyMessage', 'users'));
    }

    public function edit($id)
    {
        $user = UserRole::findOrFail($id);
        $user_links = DB::table('user_links')->get();
        $pageTitle = $user->title;
        $emptyMessage = 'No User available';
        return view('admin.user_roles.edit', compact('pageTitle', 'user', 'emptyMessage', 'user_links'));
    }

    public function create()
    {
        $user_links = DB::table('user_links')->get();
        return view('admin.user_roles.create', compact('user_links'));
    }

    public function update(Request $request, $id)
    {


        $user = UserRole::findOrFail($id);
        // print_r($request->all());exit;
        $user->permissions = implode(",", @$request->permissions);
        $user->save();

        $notify[] = ['success', $user->title . ' Permissions has been updated'];
        return back()->withNotify($notify);
    }


    public function smsTemplate()
    {
        $pageTitle = 'SMS API';
        return view('admin.sms_template.sms_template', compact('pageTitle'));
    }

    public function smsTemplateUpdate(Request $request)
    {
        $request->validate([
            'sms_api' => 'required',
        ]);
        $general = GeneralSetting::first();
        $general->sms_api = $request->sms_api;
        $general->save();

        $notify[] = ['success', 'SMS template has been updated'];
        return back()->withNotify($notify);
    }

    public function sendTestSMS(Request $request)
    {
        $request->validate(['mobile' => 'required']);
        $general = GeneralSetting::first(['sn', 'sms_config', 'sms_api']);
        if ($general->sn == 1) {
            $gateway = $general->sms_config->name;
            $sendSms = new SendSms;
            $message = shortCodeReplacer("{{name}}", 'Admin', $general->sms_api);
            $message = shortCodeReplacer("{{message}}", 'This is a test sms', $message);
            $sendSms->$gateway($request->mobile, $general->sitename, $message, $general->sms_config);
        }

        $notify[] = ['success', 'You sould receive a test sms at ' . $request->mobile . ' shortly.'];
        return back()->withNotify($notify);
    }

    public function smsSetting()
    {
        $pageTitle = 'SMS Setting';
        return view('admin.sms_template.sms_setting', compact('pageTitle'));
    }


    public function smsSettingUpdate(Request $request)
    {
        $request->validate([
            'sms_method' => 'required|in:clickatell,infobip,messageBird,nexmo,smsBroadcast,twilio,textMagic',
            'clickatell_api_key' => 'required_if:sms_method,clickatell',
            'message_bird_api_key' => 'required_if:sms_method,messageBird',
            'nexmo_api_key' => 'required_if:sms_method,nexmo',
            'nexmo_api_secret' => 'required_if:sms_method,nexmo',
            'infobip_username' => 'required_if:sms_method,infobip',
            'infobip_password' => 'required_if:sms_method,infobip',
            'sms_broadcast_username' => 'required_if:sms_method,smsBroadcast',
            'sms_broadcast_password' => 'required_if:sms_method,smsBroadcast',
            'text_magic_username' => 'required_if:sms_method,textMagic',
            'apiv2_key' => 'required_if:sms_method,textMagic',
            'account_sid' => 'required_if:sms_method,twilio',
            'auth_token' => 'required_if:sms_method,twilio',
            'from' => 'required_if:sms_method,twilio',
        ]);

        $request->merge(['name' => $request->sms_method]);
        $data = array_filter($request->except('_token', 'sms_method'));
        $general = GeneralSetting::first();
        $general->sms_config = $data;
        $general->save();
        $notify[] = ['success', 'Sms configuration has been updated.'];
        return back()->withNotify($notify);
    }
}
