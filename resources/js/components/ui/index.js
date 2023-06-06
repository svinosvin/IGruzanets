import MyInput from "./MyInput.vue";
import MyButton from "./MyButton.vue";
import NavItem from "./NavItem.vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';     //optional for column grouping
import InputMask from 'primevue/inputmask';
import Toolbar from 'primevue/toolbar';
import Button from "primevue/button";
import MultiSelect from "primevue/multiselect";
import Dialog from "primevue/dialog";
import NavLink from "../../views/base/Admin/layout/NavLink.vue";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import Select from "./Select.vue"
import Dropdown from "primevue/dropdown";
import FileUpload from "primevue/fileupload";
import Password from "primevue/password";
import CustomToggle from './CustomToggle.vue'

export default [
    CustomToggle,
    Password,
    Dropdown,
    Toolbar,
    MyButton,
    MyInput,
    NavLink,
    NavItem,
    DataTable,
    Column,
    ColumnGroup,
    InputMask,
    Button,
    MultiSelect,
    Dialog,
    InputText,
    Textarea,
    Select,
    FileUpload
]
