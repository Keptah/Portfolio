Table export;
Table inport;

void setup() {
  inport = loadTable("430_data_injection_3.csv", "header");
  export = new Table();
  printArray(inport);


  for (TableRow row : inport.rows()) {
    String date = row.getString("date");
    String time = row.getString("time");
    time = time.substring(0, 5);
    String datetime = date + " " + time;
    println(time);
    TableRow newRow = export.addRow();
    newRow.setString("datetime", datetime);
  }
  saveTable(export, "result.csv");
}
