<?php


namespace App\Helper;


use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CForm
{
    public function __construct()
    {
    }

    public function open($method = "post", $action = "", $form_type = "basic")
    {
        $raw_html = "<form action='$action' ";
        $append = $form_type !== "basic" ? "enctype='multipart/form-data'" : '';
        if ($method == "post" || $method == "get") {
            $raw_html .= "method='$method'" . $append;
        } else {
            $method = "post";
            $raw_html .= "method='$method'" . $append;
            return $raw_html . ">" . $this->generateCsrf() . $this->hiddenBox("_method", $method);
        }
        return $raw_html . ">" . $this->generateCsrf();
    }

    public function textBox($name, $value, $placeholder = '', $id = '', $class = '', $append = '')
    {
        return new HtmlString("<input type='text' placeholder='$placeholder' name='$name' id='$id' value='$value' class='$class' $append/>\n");
    }

    public function numberBox($name, $value, $placeholder = '', $id = '', $class = '', $append = '')
    {
        return new HtmlString("<input type='number' placeholder='$placeholder' name='$name' id='$id' value='$value' class='$class' $append/>\n");
    }

    public function emailBox($name, $value, $placeholder = '', $id = '', $class = '', $append = '')
    {
        return new HtmlString("<input type='email' placeholder='$placeholder' name='$name' id='$id' value='$value' class='$class' $append/>\n");
    }

    public function colorBox($name, $value, $id = '', $class = '', $append = '')
    {
        return new HtmlString("<input type='color' value='$value' id='$id' name='$name' class='$class' $append>\n");
    }

    public function generateNewLine($how_many)
    {
        $html = '';
        for ($i = 1; $i <= $how_many; $i++) {
            $html .= "\n";
        }
        return $html;
    }

    public function generateTab($how_many)
    {
        $html = '';
        for ($i = 1; $i <= $how_many; $i++) {
            $html .= "\t";
        }
        return $html;
    }

    /**
     * Note: Specifically designed for setting page
     * @param $label_name
     * @param $field_name
     * @param $field_value
     * @param $placeholder
     * @param string $field_class
     * @param string $field_id
     * @param bool $required
     * @param string $required_class
     * @param string $type
     * @return HtmlString
     */
    public function completeTextBox($label_name, $field_name, $field_value, $placeholder, $field_class = '', $field_id = '', $required = false, $required_class = '', $type = 'textbox')
    {
        if (is_array($field_value)) {
            $field_value = isset($field_value[$field_name]) ? $field_value[$field_name] : '';
        }
        if (is_object($field_value)) {
            $field_value = isset($field_value->$field_name) ? $field_value->$field_name : '';
        }
        $raw_html = "";
        $append = '';
        $raw_html .= "<div class='input-group'>" . $this->generateNewLine(1) . $this->generateTab(10);
        $raw_html .= "<div class='input-group-prepend'>" . $this->generateNewLine(1) . $this->generateTab(11);
        $raw_html .= "<span class='input-group-text'>" . $label_name;
        if ($required) {
            if (\Session::has("star") && \Session::get("star") == "on") {
                $raw_html .= $this->generateStar($required_class);
            }
            $append = 'required ';
        }
        $raw_html .= $this->generateInfoToolTipByFieldName($field_name);
        $raw_html .= "</span>" . $this->generateNewLine(1) . $this->generateTab(10);
        $raw_html .= "</div>" . $this->generateNewLine(1) . $this->generateTab(10);
        if (empty($field_id)) {
            $field_id = $field_name;
        }
        if (empty($field_class)) {
            $field_class = "form-control";
        }
        $tmp = "";
        if ($type == "textbox") {
            $tmp = $this->textBox($field_name, old($field_name, $field_value ? $field_value : null), $placeholder, $field_id,
                    $field_class, $append) . $this->generateNewLine(1) . $this->generateTab(9);
        }
        if ($type == "number") {
            $tmp = $this->numberBox($field_name, old($field_name, $field_value ? $field_value : null), $placeholder, $field_id,
                    $field_class, $append) . $this->generateNewLine(1) . $this->generateTab(9);
        }
        if ($type == "email") {
            $tmp = $this->emailBox($field_name, old($field_name, $field_value ? $field_value : null), $placeholder, $field_id,
                    $field_class, $append) . $this->generateNewLine(1) . $this->generateTab(9);
        }
        if ($type == "color") {
            $tmp = $this->colorBox($field_name, old($field_name, $field_value ? $field_value : null), $field_id, $field_class, $append);
        }
        $raw_html .= $tmp;

        $raw_html .= '</div>';
        return new HtmlString($raw_html);
    }

    /**
     * Note: Specificall designed for setting page
     * @param $label_name
     * @param $label_css
     * @param $field_name
     * @param $field_value
     * @param $placeholder
     * @param string $field_class
     * @param string $field_id
     * @param bool $required
     * @param string $required_class
     * @param bool $touch_name
     * @return HtmlString
     */
    public function completeToggleBox($label_name, $label_css, $field_name, $field_value, $placeholder, $field_class = '',
                                      $field_id = '', $required = false, $required_class = '', $touch_name = true)
    {
        if (is_array($field_value)) {
            $field_value = isset($field_value[$field_name]) ? $field_value[$field_name] : '';
        }
        if (is_object($field_value)) {
            $field_value = isset($field_value->$field_name) ? $field_value->$field_name : '';
        }
        $raw_html = "";
        $append = '';
        $raw_html .= "<div class='input-group'>" . $this->generateNewLine(1) . $this->generateTab(10);
        $raw_html .= "<div class='input-group-prepend toggle_prepend_holder'>" . $this->generateNewLine(1) . $this->generateTab(11);
        $raw_html .= "<span class='input-group-text $label_css'>" . $label_name;
        if ($required) {
            if (\Session::has("star") && \Session::get("star") == "on") {
                $raw_html .= $this->generateStar($required_class);
            }
            $append = 'required ';
        }
        $raw_html .= $this->generateInfoToolTipByFieldName($field_name);
        $raw_html .= "</span>" . $this->generateNewLine(1) . $this->generateTab(10);
        $raw_html .= "</div>" . $this->generateNewLine(1) . $this->generateTab(10);
        if (empty($field_id)) {
            $field_id = $field_name;
        }
        if (empty($field_class)) {
            $field_class = "form-control";
        }
        $tmp = "";
        $tmp .= "<input type='checkbox' tmp_name='$field_name' class='$field_class toggle_item' ";
        if (old($field_name, $field_value)) {
            $tmp .= "checked value='1' ";
        } else {
            $tmp .= "value='0' ";
        }
        $tmp .= "data-toggle='toggle'>" . $this->generateNewLine(1) . $this->generateTab(10);
        if ($touch_name) {
            $tmp .= $this->hiddenBox("toggles[" . $field_name . "]", $field_value);
        } else {
            $tmp .= $this->hiddenBox($field_name, $field_value);
        }
        $raw_html .= $tmp . $this->generateNewLine(1) . $this->generateTab(9);
        $raw_html .= '</div>';
        return new HtmlString($raw_html);
    }

    /**
     * Note: Specifically designed for setting page
     * @param $label_name
     * @param $label_css
     * @param $field_name
     * @param $field_value
     * @param $placeholder
     * @param string $field_class
     * @param string $field_id
     * @param bool $required
     * @param string $required_class
     * @param bool $clipboard
     * @return HtmlString|string
     */
    public function completeSelectBox2($label_name, $label_css, $field_name, $field_value, $placeholder, $field_class = '', $field_id = '', $required = false, $required_class = '', $clipboard = false)
    {
        if (!isset($field_value[$field_name])) {
            return "";
        }
        $raw_html = "";
        $append = '';
        $raw_html .= "<div class='input-group'>" . $this->generateNewLine(1) . $this->generateTab(10);
        $raw_html .= "<div class='input-group-prepend'>" . $this->generateNewLine(1) . $this->generateTab(11);
        $raw_html .= "<span class='input-group-text $label_css'>" . $label_name;
        if ($required) {
            if (\Session::has("star") && \Session::get("star") == "on") {
                $raw_html .= $this->generateStar($required_class);
            }
            $append = 'required ';
        }
        $raw_html .= $this->generateInfoToolTipByFieldName($field_name);
        if ($clipboard) {
            $raw_html .=
                "<button type='button' class='btn btn-xs' onclick='copyToClipboard(\"" . implode("|", $field_value[$field_name]) . "|\")'><i class='far fa-copy ml-1'></i></button>";
        }
        $raw_html .= "</span>" . $this->generateNewLine(1) . $this->generateTab(10);
        $raw_html .= "</div>" . $this->generateNewLine(1) . $this->generateTab(10);
        if (empty($field_id)) {
            $field_id = $field_name;
        }
        if (empty($field_class)) {
            $field_class = "form-control";
        }

        $raw_html .= "<div class='form-control' style='padding:0;border: 0;height: auto;'>" . $this->generateNewLine(1) . $this->generateTab(11);
        $tmp = "<select class='tag_select2' name='" . $field_name . "[]' style='width: 100%' multiple='multiple'>" . $this->generateNewLine(1) . $this->generateTab(13);
        if (is_array($field_value[$field_name])) {
            foreach (count($field_value[$field_name]) ? $field_value[$field_name] : array() as $data) {
                $tmp .= "<option selected='selected'>$data</option>" . $this->generateNewLine(1) . $this->generateTab(13);
            }
        }
        $tmp .= "</select>" . $this->generateNewLine(1) . $this->generateTab(12);
        $raw_html .= $tmp . "</div>" . $this->generateNewLine(1) . $this->generateTab(11);
        $raw_html .= "</div>";
        return new HtmlString($raw_html);
    }

    /**
     * Note specifically designed for setting page
     * @param $label_name
     * @param $label_css
     * @param $field_name
     * @param $field_value
     * @param $selected
     * @param string $field_class
     * @param string $field_id
     * @param bool $required
     * @param string $required_class
     * @return HtmlString|string Html for selectbox
     */
    public function completeSelectBox($label_name, $label_css, $field_name, $field_value, $selected, $field_class = '', $field_id = '', $required = false, $required_class = '')
    {

        $raw_html = "";
        $append = '';
        $raw_html .= "<div class='input-group'>" . $this->generateNewLine(1) . $this->generateTab(10);
        $raw_html .= "<div class='input-group-prepend'>" . $this->generateNewLine(1) . $this->generateTab(11);
        $raw_html .= "<span class='input-group-text $label_css'>" . $label_name;
        if ($required) {
            if (\Session::has("star") && \Session::get("star") == "on") {
                $raw_html .= $this->generateStar($required_class);
            }
            $append = 'required ';
        }
        $raw_html .= $this->generateInfoToolTipByFieldName($field_name);

        $raw_html .= "</span>" . $this->generateNewLine(1) . $this->generateTab(10);
        $raw_html .= "</div>" . $this->generateNewLine(1) . $this->generateTab(10);
        if (empty($field_id)) {
            $field_id = $field_name;
        }
        if (empty($field_class)) {
            $field_class = "form-control";
        }


        $tmp = "<select $append class='$field_class' name='$field_name'>" . $this->generateNewLine(1) . $this->generateTab(13);
        $tmp .= "<option value=''>" . __("common.choose") . "</option>" . $this->generateNewLine(1) . $this->generateTab(12);;
        if (is_array($field_value)) {
            foreach (count($field_value) ? $field_value : array() as $key => $value) {
                $tmp .= "<option value='$key'";
                if ($key == $selected) {
                    $tmp .= " selected";
                }
                $tmp .= ">" . Str::title($value) . "</option>" . $this->generateNewLine(1) . $this->generateTab(12);
            }
        }
        $tmp .= "</select>" . $this->generateNewLine(1) . $this->generateTab(12);
        $raw_html .= $tmp . $this->generateNewLine(1) . $this->generateTab(11);
        $raw_html .= "</div>";
        return new HtmlString($raw_html);
    }

    public function generateStar($class = 'ml-2')
    {
        if (empty($class)) {
            $class = 'ml-2';
        }
        return new HtmlString("<span class='text-danger $class'>*</span>");
    }


    public function generateInfoToolTip($title = '', $class = '', $placement = 'top')
    {
        if (empty($class)) {
            $class = 'ml-2';
        }
        if (empty($title)) {
            $title = '';
        }
        if (empty($placement)) {
            $placement = "top";
        }
        return new HtmlString("<i class='fas fa-info-circle $class' data-toggle='tooltip' data-placement='$placement'  title='$title'></i>");
    }

    public function generateInfoToolTipByFieldName($field_name = '', $class = '', $placement = 'top')
    {
        $title = '';
        if (empty($class)) {
            $class = 'ml-2';
        }
        if (empty($field_name)) {
            return '';
        }
        if (Lang::has("tooltip." . $field_name)) {
            $title = Lang::get("tooltip." . $field_name);
        } else {
            return '';
        }
        if (empty($placement)) {
            $placement = "top";
        }
        return new HtmlString("<i class='fas fa-info-circle $class' data-toggle='tooltip' data-placement='$placement'  title='$title'></i>\n");
    }

    public function hiddenBox($name, $value, $id = '')
    {
        if (empty($id)) {
            $id = $name;
            if (substr_count($name, "[") == 1) { #Single dimenstional array
                $id = Str::between($name, "[", "]");
            } else {# Mutidimentional Array
                $id = Str::of($name)->replace(["[", "]"], "_")->__toString();
            }

        }
        return new HtmlString("<input type='hidden' name='$name' id='$id' value='$value'/>\n");
    }

    public function textArea($name, $value, $id = '', $class = '', $append = '')
    {
        if (empty($id)) {
            $id = $name;
        }
        return new HtmlString("<textarea name='$name' id='$id' class='$class' $append>$value</textarea>\n");
    }

    public function generateCsrf()
    {
        return $this->hiddenBox("_token", csrf_token());
    }

    public function star_status($status = 'on')
    {
//        Session::flash('star', $status);
//        Session::save();
    }

    /**
     * Will be using this wrapper inside livewire components [Bootstrap 4] [Default]
     * 2 function should be used together a header one and a footer one.
     * @param $label_name string Text For the label
     * @param string $label_prepend_css Append any class to the [label wrapper]
     * @param string $label_text_css Append any class to text holder
     * @return HtmlString Return an html string
     */
    public function inputGroupHeader($label_name, $label_prepend_css = '', $label_text_css = '')
    {
        $raw_html = "<div class='input-group'>";
        $raw_html .= "<div class='input-group-prepend $label_prepend_css'>";
        $raw_html .= "<span class='input-group-text $label_text_css'>$label_name</span>";
        $raw_html .= " </div>";
        return new HtmlString($raw_html);
    }

    /**
     * Return a closing div tag
     * @return HtmlString
     */
    public function inputGroupFooter()
    {
        return new  HtmlString("</div>");
    }

    /**
     * Will be using this wrapper inside front end  [Bootstrap 3]
     * @param $label_name  string Text For the label
     * @param string $label_text_css Append any class to text holder
     * @return HtmlString Return an html string
     */
    public function inputGroupHeader3($label_name, $label_text_css = '')
    {
        $raw_html = "<div class='input-group'>";
        $raw_html .= "<span class='input-group-addon $label_text_css'>$label_name</span>";
        return new HtmlString($raw_html);
    }

    /**
     * Return a closing div tag
     * @return HtmlString
     */
    public function inputGroupFooter3()
    {
        return new  HtmlString("</div>");
    }


    /**
     * Return a closing Form tag
     * @return HtmlString
     */
    public function close()
    {
        return new HtmlString("</form>\n");
    }

    public function calloutSuccess($sub_heading, $wrapper_cls = "", $heading_cls = '', $sub_heading_cls = '', $id = "", $heading = "")
    {
        return $this->callout("callout-success", $sub_heading, $wrapper_cls, $heading_cls, $sub_heading_cls, $id, $heading);
    }

    public function calloutInfo($sub_heading, $wrapper_cls = "", $heading_cls = '', $sub_heading_cls = '', $id = "", $heading = "")
    {
        return $this->callout("callout-info", $sub_heading, $wrapper_cls, $heading_cls, $sub_heading_cls, $id, $heading);
    }

    public function calloutDanger($sub_heading, $wrapper_cls = "", $heading_cls = '', $sub_heading_cls = '', $id = "", $heading = "")
    {
        return $this->callout("callout-danger", $sub_heading, $wrapper_cls, $heading_cls, $sub_heading_cls, $id, $heading);
    }

    public function calloutWarning($sub_heading, $wrapper_cls = "", $heading_cls = '', $sub_heading_cls = '', $id = "", $heading = "")
    {
        return $this->callout("callout-warning", $sub_heading, $wrapper_cls, $heading_cls, $sub_heading_cls, $id, $heading);
    }

    public function callout($type, $sub_heading, $wrapper_cls = "", $heading_cls = '', $sub_heading_cls = '', $id = "", $heading = "")
    {
        $appender = \Util::getIfNotEmpty($id) ? "id='$id'" : '';
        $raw_html = "
                    <div class='callout $type $wrapper_cls' $appender>
                    <button type = 'button' class='close closeCurrentCallout' >
                    <span aria-hidden='true' >&times;</span ></button > ";
        if (!empty($heading)) {
            $raw_html .= "<h5 class='$heading_cls' > $heading</h5 > ";
        }
        if (!empty($sub_heading)) {
            $raw_html .= "<p class='$sub_heading_cls' > $sub_heading</p > ";
        }

        $raw_html .= "</div > ";
        return new HtmlString($raw_html);
    }

}
