<?php

class Util
{
    // ... existing methods ...

    public function renderHeaderButton($screenTitleRightButtonId, $screenTitleRightButtonLink, $screenTitleRightButtonIcon, $screenTitleRightButtonText, $additionalButton = null)
    {
        // Render the main right button
        echo '<a id="' . $screenTitleRightButtonId . '" href="' . $screenTitleRightButtonLink . '" class="btn btn-primary">' . $screenTitleRightButtonText . '</a>';

        // Check if there is an additional button to render
        if ($additionalButton) {
            echo '<button id="' . $additionalButton['id'] . '" class="' . $additionalButton['class'] . '">' . $additionalButton['text'] . '</button>';

            // If there is a script, echo it
            if (isset($additionalButton['script'])) {
                echo '<script>' . $additionalButton['script'] . '</script>';
            }
        }
    }
}

function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}