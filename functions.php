/**
 * Generate back-end test questions page
 */
function ec_test_main_page() {
    $output = '
        <div id="interviewTest" class="wrap">
            <h1 class="wp-heading-inline">Interview Test Questions</h1>
            <a id="saveQuestions" class="button button-primary button-large">Update</a>
            <hr class="wp-header-end">
            <table id="testQuestions" class="wp-list-table widefat">
                <tr>
                    <th>id</th>
                    <th>question</th>
                    <th>category</th>
                    <th>numOfCorAnswers</th>
                    <th>correctOption</th>
                    <th>option1</th>
                    <th>option2</th>
                    <th>option3</th>
                    <th>option4</th>
                    <th>option5</th>
                    <th>option6</th>
                </tr><tbody class="the-list">
        ';

    $hostname = '127.0.0.1';
    $username = 'root';
    $password = 'root';
    $dbname = 'correctwpdb';
    $port = '8889';

    $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port;charset=utf8", $username, $password);

    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $conn->prepare('SELECT position, question, category, numOfCorAnswers, correctOption, option1, option2, option3, option4, option5, option6 FROM testquestions ORDER BY position');

    $stmt->execute();

    $questions = $stmt->fetchAll(PDO::FETCH_NUM);

    foreach ($questions as $key => $value) {
        $output = $output . "
            <tr>
                <th>". $value[0] ."</th>
                <td><div id='td1-row". $key ."' contenteditable='true'>". $value[1] ."</div></td>
                <td><div id='td2-row". $key ."' contenteditable='true'>". $value[2] ."</div></td>
                <td><div id='td3-row". $key ."' contenteditable='true'>". $value[3] ."</div></td>
                <td><div id='td4-row". $key ."' contenteditable='true'>". $value[4] ."</div></td>
                <td><div id='td5-row". $key ."' contenteditable='true'>". $value[5] ."</div></td>
                <td><div id='td6-row". $key ."' contenteditable='true'>". $value[6] ."</div></td>
                <td><div id='td7-row". $key ."' contenteditable='true'>". $value[7] ."</div></td>
                <td><div id='td8-row". $key ."' contenteditable='true'>". $value[8] ."</div></td>
                <td><div id='td9-row". $key ."' contenteditable='true'>". $value[9] ."</div></td>
                <td><div id='td10-row". $key ."' contenteditable='true'>". $value[10] ."</div></td>
            </tr>
        ";
    }

    $output = $output . "</tbody></table></div>";
    echo $output;
}


/**
 * Generate back-end test results page
 */
function ec_test_results_page() {
    $output = "
        <div id='interviewTest' class='wrap'>
            <h1 class='wp-heading-inline'>Results</h1>
            <hr class='wp-header-end'>
            <table id='testResults' class='wp-list-table widefat'>
                <tr>
                    <th>name</th>
                    <th>result</th>
                    <th>time</th>
                    <th>datetime</th>
                </tr>
                <tbody class='the-list'>
        ";

    $hostname = '127.0.0.1';
    $username = 'root';
    $password = 'root';
    $dbname = 'correctwpdb';
    $port = '8889';

    $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port;charset=utf8", $username, $password);

    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $conn->prepare('SELECT * FROM testresponders INNER JOIN testanswers on testresponders.userId = testanswers.userId INNER JOIN testquestions on testanswers.questionId = testquestions.questionId');

    $stmt->execute();

    $questions = $stmt->fetchAll(PDO::FETCH_NUM);

    foreach ($questions as $key => $value) {
        if ($questions[$key - 1][0] !== $value[0]) {
            $output = $output . '
                <tr class="row">
                    <td>'. $value[1] .'</td>
                    <td>'. $value[2] .'</td>
                    <td>'. $value[3] .'</td>
                    <td>'. $value[4] .'</td>
                </tr>
                <tr class="collapse">
                    <th colspan="3">question</th>
                    <th colspan="2">answer</th>
                </tr>
            ';
        }

        if ($value[14] === $value[8]) {
            $color = "#abd9ab";
        } else {
            $color = "#ffb2b2";
        }

        $output = $output . '
            <tr class="collapse" style="background:'. $color .'">
                <td colspan="3">'. $value[11] .'</td>
                <td colspan="2">'. $value[8] .'</td>
            </tr>
        ';
    }

    $conn = $stmt1 = $stmt2 = null;
    $output = $output . '</tbody></table></div>';
    echo $output;
}


/**
 * Generate back-end add a question page
 */
function ec_add_remove_question_page() {
    $output = "
        <div id='addRemoveQuestion' class='wrap'>
            <h1 class='wp-heading-inline'>Add a question</h1>
            <hr class='wp-header-end'>
            <div id='addAQuestion'>
                <label for='testPosition'>Enter after question: </label>
                <select id='testPosition'>
        ";

    $hostname = '127.0.0.1';
    $username = 'root';
    $password = 'root';
    $dbname = 'correctwpdb';
    $port = '8889';

    $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port;charset=utf8", $username, $password);

    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $conn->prepare('SELECT position FROM testquestions ORDER BY position');

    $stmt->execute();

    $questions = $stmt->fetchAll(PDO::FETCH_NUM);

    foreach ($questions as $value) {
        $output = $output . '<option>'. $value[0] .'</option>';
    }

    $output = $output .'
        </select><br>
        <label for="question">Question:</label>
        <textarea id="question" placeholder="You are trying to connect via remote desktop to a Windows 7 computer with a 3rd-party firewall installed, you need to allow remote desktop access, what port would you allow?" required></textarea><br>

        <label for="category">Category:</label>
        <textarea id="category" placeholder="General Support" required></textarea><br>

        <label for="numOfCorAnswers">Number of correct answers: </label>
        <textarea id="numOfCorAnswers" placeholder="1" required></textarea><br>

        <label for="correctOption">Correct answers:</label>
        <textarea id="correctOption" placeholder="3389" required></textarea><br>

        <label for="option1">Option 1:</label>
        <textarea id="option1" placeholder="1723" required></textarea><br>

        <label for="option2">Option 2:</label>
        <textarea id="option2" placeholder="110" required></textarea><br>

        <label for="option3">Option 3:</label>
        <textarea id="option3" placeholder="3389"></textarea><br>

        <label for="option4">Option 4:</label>
        <textarea id="option4" placeholder="you do not need to open a port"></textarea><br>

        <label for="option5">Option 5:</label>
        <textarea id="option5"></textarea><br>

        <label for="option6">Option 6:</label>
        <textarea id="option6"></textarea><br>

        <button class="button button-primary button-large" id="addQuestion">Add question</button><br><br>
        <div id="addResponse"></div><br>
        </div>
        <div id="removeAQuestion">
            <h1 class="wp-heading-inline">Remove a question</h1>
            <hr class="wp-header-end">
            <label for="removingQuestion">Remove question:</label>
            <select id="removingQuestion">
    ';

    foreach ($questions as $value) {
        $output = $output . '<option>'. $value[0] .'</option>';
    }

    $output = $output .'
        </select><br>
        <button class="button button-primary button-large" id="removeQuestion">Remove question</button><br><br><br>
        <div id="removeResponse"></div>
        </div>
        </div>
    ';

    echo $output;
}


/**
 * Adds interview test admin menu
 */
function add_test_admin_menu() {
    add_menu_page("Interview Test Questions", "Interview Test", "edit_theme_options", "interview_test", ec_test_main_page, 200);
    add_submenu_page("interview_test", "Test Results", "Results", "edit_theme_options", "test_results", ec_test_results_page);
    add_submenu_page("interview_test", "Add/Remove Question", "Add/Remove a question", "edit_theme_options", "add_remove_question", ec_add_remove_question_page);
}
add_action('admin_menu', 'add_test_admin_menu');


/**
 * Update database with changed questions
 */
function ec_update_questions() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $changes = $_POST['changes'];

        $hostname = '127.0.0.1';
        $username = 'root';
        $password = 'root';
        $dbname = 'correctwpdb';
        $port = '8889';

        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port;charset=utf8", $username, $password);

        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $test = [];
        foreach ($changes as $key => $value) {
            $columnName = $value[1];

            $stmt = $conn->prepare('UPDATE testquestions SET '. $columnName .' = :columnValue WHERE position = :position');

            $stmt->bindValue(':position', $value[0], PDO::PARAM_INT);
            $stmt->bindValue(':columnValue', $value[2], PDO::PARAM_STR);

            $stmt->execute();
        }

        $conn = $stmt = null;
        exit();
    }
}
add_action( 'wp_ajax_ec_update_questions', 'ec_update_questions' );


/**
 * Add new question to database
 */
function ec_add_question() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $questionDetails = $_POST['questionDetails'];

        $questionDetails = array_map(function($value) {
            return $value === "" ? NULL : $value;
        }, $questionDetails);

        $hostname = '127.0.0.1';
        $username = 'root';
        $password = 'root';
        $dbname = 'correctwpdb';
        $port = '8889';

        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port;charset=utf8", $username, $password);

        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $stmt = $conn->prepare('UPDATE testquestions SET position = position + 1 WHERE (position >= :position)');

        $stmt->bindValue(':position', $questionDetails[0], PDO::PARAM_INT);

        $stmt->execute();

        $stmt = null;

        $stmt = $conn->prepare('INSERT INTO testquestions (position, question, category, numOfCorAnswers, correctOption, option1, option2, option3, option4, option5, option6) VALUES (:position, :question, :category, :numOfCorAnswers, :correctOption, :option1, :option2, :option3, :option4, :option5, :option6)');

        $stmt->bindValue(':position', $questionDetails[0], PDO::PARAM_INT);
        $stmt->bindValue(':question', $questionDetails[1], PDO::PARAM_STR);
        $stmt->bindValue(':category', $questionDetails[2], PDO::PARAM_STR);
        $stmt->bindValue(':numOfCorAnswers', $questionDetails[3], PDO::PARAM_INT);
        $stmt->bindValue(':correctOption', $questionDetails[4], PDO::PARAM_STR);
        $stmt->bindValue(':option1', $questionDetails[5], PDO::PARAM_STR);
        $stmt->bindValue(':option2', $questionDetails[6], PDO::PARAM_STR);
        $stmt->bindValue(':option3', $questionDetails[7], PDO::PARAM_STR);
        $stmt->bindValue(':option4', $questionDetails[8], PDO::PARAM_STR);
        $stmt->bindValue(':option5', $questionDetails[9], PDO::PARAM_STR);
        $stmt->bindValue(':option6', $questionDetails[10], PDO::PARAM_STR);

        $stmt->execute();

        $conn = $stmt = null;
        exit();
    }
}
add_action( 'wp_ajax_ec_add_question', 'ec_add_question' );


/**
 * Remove question from database
 */
function ec_remove_question() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $position = $_POST['position'];

        $hostname = '127.0.0.1';
        $username = 'root';
        $password = 'root';
        $dbname = 'correctwpdb';
        $port = '8889';

        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port;charset=utf8", $username, $password);

        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $stmt = $conn->prepare('DELETE FROM testquestions WHERE position = :position');

        $stmt->bindValue(':position', $position, PDO::PARAM_INT);

        $stmt->execute();

        $stmt = null;

        $stmt = $conn->prepare('UPDATE testquestions SET position = position - 1 WHERE position > :position');

        $stmt->bindValue(':position', $position, PDO::PARAM_INT);

        $stmt->execute();

        $conn = $stmt = null;
        exit();
    }
}
add_action( 'wp_ajax_ec_remove_question', 'ec_remove_question' );


/**
 * Retrieves questions from database
 */
function ec_start_test() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $hostname = '127.0.0.1';
        $username = 'root';
        $password = 'root';
        $dbname = 'correctwpdb';
        $port = '8889';

        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port;charset=utf8", $username, $password);

        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $stmt = $conn->prepare('SELECT position, question, category, numOfCorAnswers, option1, option2, option3, option4, option5, option6 FROM testquestions ORDER BY position');

        $stmt->execute();
        
        $questions = $stmt->fetchAll(PDO::FETCH_NUM);

        $stmt = null;
        
        $stmt = $conn->prepare('SELECT category FROM testquestions');

        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        $data['questions'] = $questions;
        $data['categories'] = array_count_values($categories);
        
        $conn = $stmt = null;
        echo json_encode($data);
        exit();
    }
}
add_action( 'wp_ajax_ec_start_test', 'ec_start_test' );
add_action( 'wp_ajax_nopriv_ec_start_test', 'ec_start_test' );


/**
 * Submit test question answers
 */
function ec_submit_test() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $responses = $_POST['responses'];
        $name = $_POST['name'];
        $time = gmdate("H:i:s", $_POST['seconds']);

        $hostname = '127.0.0.1';
        $username = 'root';
        $password = 'root';
        $dbname = 'correctwpdb';
        $port = '8889';

        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port;charset=utf8", $username, $password);

        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $stmt = $conn->prepare('SELECT questionId, correctOption FROM testquestions ORDER BY position');

        $stmt->execute();

        $answers = $stmt->fetchAll(PDO::FETCH_NUM);

        $correct = 0;
        foreach ($answers as $key => $value) {
            if ($value[1] === $responses[$key]) {
                $correct++;
            }
        }
        $result = $correct . '/' . count($responses);

        $stmt = null;

        $stmt = $conn->prepare('INSERT INTO testresponders (name, result, time, datetime) VALUES (:name, :result, :time, :datetime);');

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':result', $result, PDO::PARAM_STR);
        $stmt->bindValue(':time', $time, PDO::PARAM_STR);
        $stmt->bindValue(':datetime', date("Y-m-d G:i:s"), PDO::PARAM_STR);

        $stmt->execute();

        $stmt = null;

        $stmt = $conn->prepare('INSERT INTO testanswers (userId, questionId, answer) VALUES (:userId, :questionId, :answer);');
        
        $stmt->bindValue(':userId', $conn->lastInsertId(), PDO::PARAM_STR);
        
        foreach ($responses as $key => $value) {
            $stmt->bindValue(':questionId', $answers[$key][0], PDO::PARAM_STR);
            $stmt->bindValue(':answer', $value, PDO::PARAM_STR);
            $stmt->execute();
        }

        $conn = $stmt = null;
        echo json_encode($correct . " out of " . count($responses));
        exit();
    }
}
add_action( 'wp_ajax_ec_submit_test', 'ec_submit_test' );
add_action( 'wp_ajax_nopriv_ec_submit_test', 'ec_submit_test' );
