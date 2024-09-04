<?php
include ("../config.php");
include ("../session.php");

$response = array('success' => false, 'message' => '', 'data' => array());

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_schedule = $_POST['id_schedule'];

    $sql = "SELECT kyb_problem, kyb_bukti_foto FROM kyb_trsproblem WHERE kyb_id_schedule = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_schedule);
        if ($stmt->execute()) {
            $stmt->bind_result($kyb_problem, $kyb_bukti_foto);

            while ($stmt->fetch()) {
                $response['data'][] = array(
                    'kyb_problem' => $kyb_problem,
                    'kyb_bukti_foto' => $kyb_bukti_foto
                );
            }

            if (count($response['data']) > 0) {
                $response['success'] = true;
            } else {
                $response['message'] = 'No problem found for this schedule.';
            }
            $stmt->close();
        } else {
            $response['message'] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    } else {
        $response['message'] = "Failed to prepare statement: " . $conn->error;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>