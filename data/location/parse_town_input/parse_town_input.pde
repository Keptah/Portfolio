Table districts;
Table towns;
Table export;
void setup() {

  districts = loadTable("District_dial.csv", "header");
  towns = loadTable("Towns_raw.csv", "header");
  
  export = new Table();
  export.addColumn("town_code");
  export.addColumn("town_name");
  export.addColumn("town_in_district_code");
  export.addColumn("town_in_region_code");

  //println(towns.getRowCount() + " total rows in table");

  for (TableRow row : towns.rows()) {
    String town_code = row.getString("town_code");
    String town_name = row.getString("town_name");
    String town_in_district_name = row.getString("town_in_district_name");

    TableRow newRow  = export.addRow();
    newRow.setString("town_code", town_code);
    newRow.setString("town_name", town_name);

    for (TableRow k_row : districts.rows()) {
      String dis_name = k_row.getString("district_name");
      String dis_code = k_row.getString("district_code");
      
      String reg_code = k_row.getString("region_code");
      
      println(dis_name + " x " + town_in_district_name);
      
      if (dis_name.equals(town_in_district_name)) {
          //String k_code_of_o = k_code;
        println("#######################################################");
        println("obec jemnem " + town_name + " s kodem " + town_code +
        " která se nachází v okresu " + dis_name + " s kodem " + dis_code +
        " nacházející se v kraji s kódem " + reg_code);
        newRow.setString("town_in_district_code", dis_code);
        newRow.setString("town_in_region_code", reg_code);
        break;
      }
    }
  }
  saveTable(export, "data_export_test.csv");
}
