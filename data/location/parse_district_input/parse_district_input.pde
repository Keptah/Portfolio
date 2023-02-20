Table okresy;
Table kraje;
Table export;
void setup() {

  okresy = loadTable("CiselnikOkresu.csv", "header");
  kraje = loadTable("Region_id.csv", "header");
  export = new Table();
  export.addColumn("district_name");
  export.addColumn("district_code");
  export.addColumn("region_code");

  println(okresy.getRowCount() + " total rows in table");

  for (TableRow row : okresy.rows()) {
    String o_code = row.getString("code");
    String o_name = row.getString("dist_name");
    String o_k_name = row.getString("reg_name");

    TableRow newRow  = export.addRow();
    newRow.setString("district_name", o_name);
    newRow.setString("district_code", o_code);

    for (TableRow k_row : kraje.rows()) {
      String k_name = k_row.getString("reg_name");
      String k_code = k_row.getString("code");
      
      println(k_name + " x " + o_k_name);
      
      if (k_name.equals(o_k_name)) {
          //String k_code_of_o = k_code;
        println("#######################################################");
        println("okres " + o_name + " s kódem " + o_code +  " okres patri do " + o_k_name + " jehoz kod je " + k_code);
        newRow.setString("region_code", k_code);
        break;
      }
    }
  }
  saveTable(export, "region_code_result.csv");
}
