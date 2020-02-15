<?php
#app/Http/Admin/Controllers/AdminUrlConfigController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminConfig;

class AdminUrlConfigController extends Controller
{

    public function index()
    {
        $data = [
            'title' => trans('link.config_manager.title'),
            'sub_title' => '',
            'icon' => 'fa fa-indent',
            'menuRight' => [],
            'menuLeft' => [],
            'topMenuRight' => [],
            'topMenuLeft' => [],
            'menuSort' => '',
            'scriptSort' => '',
            'listTh' => '',
            'dataTr' => '',
            'pagination' => '',
            'resultItems' => '',
            'url_delete_item' => '',
        ];

        $obj = (new AdminConfig)->where('code', 'env')
            ->orderBy('sort', 'desc')
            ->get();
        $data['configs'] = $obj;

        return view('admin.screen.url_config')
            ->with($data);
    }

/*
Update value config
 */
    public function updateInfo()
    {
        $stt = 0;
        $data = request()->all();
        $name = $data['name'];
        $value = $data['value'];
        $update = AdminConfig::where('key', $name)->update(['value' => $value]);
        if ($update) {
            $stt = 1;
        }
        return response()->json(['stt' => $stt]);

    }

/*
Delete list item
Need mothod destroy to boot deleting in model
 */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            AdminConfig::destroy($arrID);
            return response()->json(['stt' => 1, 'msg' => '']);
        }
    }

}
