<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatrixController extends Controller
{
    /* 
    check for eqaul row in each matix 
    @param eg [[ 1 ,2 3 ], [1,2]] will return false and will not process as a matrix 
    @param eg [[ 1 ,2 3 ], [1,2, 5]] will return true 
    */
    public function checkMatrixRowColumn(array $matrix)
    {
        $rowLenght = count($matrix[0]);
        foreach ($matrix as $key => $value) {
            if (count(($value)) !== $rowLenght) {
                echo "matrix must have same row ";
                return;
            }
        }
    }

    /* check for eqaulity the row lenght and the column lenght between 2 matrix */
    function columnRowCheck(array $matrix1, array $matrix2)
    {
        if (count($matrix1[0]) !== count($matrix2)) {
            return "cannot process matrix : matrix1 row and matrix2 column does not have equal lenght";
        }
    }
}
