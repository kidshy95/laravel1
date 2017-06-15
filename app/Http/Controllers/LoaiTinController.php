<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    //
    public function getDanhSach()
    {
    	$loaitin = LoaiTin::all();
    	return view('admin.loaitin.danhsach', ['loaitin'=>$loaitin]);
    }

    public function getThem()
    {
    	$theloai = TheLoai::all();
    	return view('admin.loaitin.them', ['theloai'=>$theloai]);
    }

    public function postThem(Request $request)
    {
    	$this->validate($request,
    		[
    			'Ten' => 'required|unique:LoaiTin,Ten|min:3|max:100'
    		],
    		[
    			'Ten.required' => 'Bạn chưa nhập tên loại tin',
                'Ten.unique' => 'Tên loại tin đã tồn tại',
    			'Ten.min' => 'Tên loại tin phải có độ dài từ 3 đến 100 ký tự',
    			'Ten.max' => 'Tên loại thin phải có độ dài từ 3 đến 100 ký tự'
    		]
        );
    	$loaitin = new LoaiTin;
    	$loaitin->Ten = $request->Ten;
    	$loaitin->idTheLoai = $request->TheLoai;
    	$loaitin->TenKhongDau = changeTitle($request->Ten);
    	$loaitin->save();
    	
    	return redirect('admin/loaitin/them')->with('thongbao', 'Thêm loại tin thành công');
    }

    public function getSua($id)
    {
    	$loaitin = LoaiTin::find($id);
    	$theloai = TheLoai::all();
    	return view('admin.loaitin.sua', ['loaitin'=>$loaitin, 'theloai'=>$theloai]);
    }
    public function postSua(Request $request, $id)
    {
    	$loaitin = LoaiTin::find($id);
        $this->validate($request,
            [
                'Ten' => 'required|unique:LoaiTin,Ten|min:3|max:100'
            ],
            [
                'Ten.required' => 'Bạn chưa nhập tên loại tin',
                'Ten.unique' => 'Tên loại tin đã tồn tại',
                'Ten.min' => 'Tên loại tin phải có độ dài từ 3 đến 100 ký tự',
                'Ten.max' => 'Tên loại tin phải có độ dài từ 3 đến 100 ký tự'
            ]
        );

        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->save();

        return redirect('admin/loaitin/sua/' . $id)->with('thongbao', 'Sửa thể loại thành công');
    }

    public function getXoa($id)
    {
        $loaitin = LoaiTin::find($id);
        $loaitin->delete();

        return redirect('admin/loaitin/danhsach')->with('thongbao', 'Bạn đã xóa thành công');
    }
}
