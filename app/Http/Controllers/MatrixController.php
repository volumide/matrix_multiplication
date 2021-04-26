<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatrixController extends Controller
{
    public function getMatrix(Request $request)
    {
        $matrix1 = $request->m1;
        $matrix2 = $request->m2;
        $key = $request->key;
        if ($key !== "123Kyz@145!") {
            return response()->json([
                "message" => "unauthorized"
            ], 401);
        }

        if (!is_array($matrix1) || !is_array($matrix2)) {
            return response()->json([
                "message" => "matrix must be an array"
            ], 403);
        }

        // check if matix have equal rows
        if ($this->checkMatrixRowColumn($matrix1)) {
            return response()->json([
                "message" => "m1 is not a valid matix object"
            ], 403);
        }

        if ($this->$this->checkMatrixRowColumn($matrix2)) {
            return response()->json([
                "message" => "m2 is not a valid matix object"
            ], 403);
        }

        // check if the number of row in matix1 is equal to the number of column in matrix2
        $checkMatixesRowColumnSizeEquality = $this->columnRowCheck($matrix1, $matrix2);
        if ($checkMatixesRowColumnSizeEquality) {
            return response()->json([
                "message" => $checkMatixesRowColumnSizeEquality
            ], 403);
        }

        // multiply two matrix 
        $matrix3 = $this->multiplyMatrix($matrix1, $matrix2);

        // convert matrix to alphabet 
        $matrixToAlphabet = $this->convertMatrixToAlphabet($matrix3);

        return response()->json([
            "message" => "successful",
            "matrix" => $matrixToAlphabet
        ]);
    }

    public function test()
    {
        $m1 = array([1, 2], [2, 10], [3, 15]);
        $m2 = array([1, 3], [1, 5],);
        $checkM1 = $this->checkMatrixRowColumn($m1);
        $checkM2 = $this->checkMatrixRowColumn($m2);
        if ($checkM1) {
            echo "m1 is not a valid matix object ";
            return;
        }
        if ($checkM2) {
            echo "m2 is not a valid matix object ";
            return;
        }

        $checkM1M2RowColumn = $this->columnRowCheck($m1, $m2);
        if ($checkM1M2RowColumn) {
            echo $checkM1M2RowColumn;
            return;
        }
        $matrixCalc = $this->multiplyMatrix($m1, $m2);
        $convertMatrix = $this->convertMatrixToAlphabet($matrixCalc);
        return ["matrix" => $convertMatrix];
    }


    /* 
    check for equal row in each matix 
    @param eg [[ 1 ,2 3 ], [1,2]] will return false and will not process as a matrix 
    @param eg [[ 1 ,2 3 ], [1,2, 5]] will return true 
    */
    public function checkMatrixRowColumn(array $matrix)
    {
        $rowLenght = count($matrix[0]);
        foreach ($matrix as $key => $value) {
            if (count(($value)) !== $rowLenght) {
                return "error";
            }
        }
    }

    /* check for eqaulity the row lenght and the column lenght between 2 matrix */
    public function columnRowCheck(array $matrix1, array $matrix2)
    {
        if (count($matrix1[0]) !== count($matrix2)) {
            return "cannot process matrix : matrix1 row and matrix2 column does not have equal lenght";
        }
    }

    /* multiply two matrixes */
    public function multiplyMatrix(array $matrixOne, array $matrixTwo)
    {
        $matrix3 = array();
        for ($i = 0; $i < count($matrixOne); $i++) {
            for ($j = 0; $j < count($matrixTwo); $j++) {
                $matrix3[$i][$j] = 0;
                for ($m = 0; $m < count($matrixTwo); $m++) {
                    $matrix3[$i][$j] += $matrixOne[$i][$m] * $matrixTwo[$m][$j];
                }
            }
        }
        return $matrix3;
    }


    /* convert each integer to alphabet */
    public function intToChar(int $param)
    {
        $text = "";
        while ($param > 0) {
            $currentLetterNumber = ($param - 1) % 26;
            $currentLetter = chr($currentLetterNumber + 65);
            $text = $currentLetter . $text;
            $param = ($param - ($currentLetterNumber + 1)) / 26;
        }
        return $text;
    }

    /* conver each matrix integer to character */
    public function convertMatrixToAlphabet(array $matrix)
    {
        $result = [];
        foreach ($matrix as $key => $row) {
            foreach ($row as $key2 => $column) {
                $result[$key][$key2] = $this->intToChar(($column));
            }
        }
        return $result;
    }
}
