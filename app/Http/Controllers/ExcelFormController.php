<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Formulario;
use App\Models\Quarter;
use App\Models\Sidewalk;
use App\Models\Township;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelFormController extends Controller
{
    /**
     * It gets all the data from the database, then it creates a new spreadsheet, then it adds the data
     * to the spreadsheet, then it saves the spreadsheet, then it downloads the spreadsheet
     *
     * @return BinaryFileResponse
     */
    public function exportForms(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $datas = Formulario::select('nombre', 'apellido', 'email', 'telefono', 'genero', 'direccion', 'location', 'puesto_votacion', 'mensaje', 'tipo_zona')->get();

        foreach($datas as $data){
            $location = json_decode($data->location);

            if($data->tipo_zona == 'Comuna'){
                $commune = Commune::find($location->commune_id);
                $quarter = Quarter::find($location->quarter_id);
                $data->location = $commune->name . ' - ' . $quarter->name;
            }else{
                $township = Township::find($location->township_id);
                $sidewalk = Sidewalk::find($location->sidewalk_id);
                $data->location = $township->name . ' - ' . $sidewalk->name;
            }
        }

        $sheet->fromArray($datas->toArray());

        $sheet->setCellValue('A1', 'Nombre');
        $sheet->setCellValue('B1', 'Apellido');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Telefono');
        $sheet->setCellValue('E1', 'Genero');
        $sheet->setCellValue('F1', 'Direccion');
        $sheet->setCellValue('G1', 'Location');
        $sheet->setCellValue('H1', 'Puesto de votacion');
        $sheet->setCellValue('I1', 'Mensaje');
        $sheet->setCellValue('J1', 'Tipo de zona');

        $writer= new Xlsx($spreadsheet);
        $filename = 'forms-'.Carbon::now()->format('Y-m-d-H-i-s');

        $writer->save($filename.'.xlsx');

        return response()->download($filename.'.xlsx')->deleteFileAfterSend(true);
    }
}
