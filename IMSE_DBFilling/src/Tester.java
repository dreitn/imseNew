import java.sql.Date;
import java.text.SimpleDateFormat;
import java.util.Calendar;

public class Tester {

	public static void main(String[] args) {
		DatabaseHelper dbHelper=new DatabaseHelper();
		
		SimpleDateFormat sdf = new SimpleDateFormat("YYYY-MM-DD");
		int year = 2014;
		int month = 10;
		int day = 24;
		Calendar cal = Calendar.getInstance();
		cal.set(Calendar.YEAR, year);
		cal.set(Calendar.MONTH, month-1); // <-- months start
		                                    // at 0.
		cal.set(Calendar.DAY_OF_MONTH, day);

		java.sql.Date date = new java.sql.Date(cal.getTimeInMillis());
		
		
		//dbHelper.insertIntoCostumer("haaans@outlook.com", 644383058, "haans", "m�llller");
		//dbHelper.insertIntoLocation(7, 1090, "big street", "vienna");
		//dbHelper.insertIntoCar(99, "honda", 2005, 40);
		//dbHelper.insertIntoBilling(97, 197, date, "stephan@outlook.com");
		

		System.out.println(dbHelper.selectCostumerEmail());
		System.out.println(dbHelper.selectRegistrationNumber());
		System.out.println(dbHelper.selectLocationId());
		System.out.println(dbHelper.selectCountAllFromBilling());
		

	
		
		
		dbHelper.close();
	}

}
