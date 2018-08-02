/**
 * Adds [interview-test] shortcode
 */
function ec_interview_test() {
    return '<div class="text">Enter your name and click start to begin the test.</div>
            <input type="text" id="testName" required>
            <div class="test-error"></div>
            <button class="button" id="startTest">Start test</button>
            <div class="interview-questions">
                <div class="timer"></div>
            </div>
            <div class="nav-buttons">
                <button class="button" id="testPrev">Previous</button>
                <button class="button" id="testNext">Next</button>
                <button class="button" id="testSubmit">Submit</button>
            </div>';
}
add_shortcode( 'interview-test', 'ec_interview_test' );
