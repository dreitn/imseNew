import java.sql.Date;
import java.text.SimpleDateFormat;
import java.util.Calendar;

public class Tester {

	public static void main(String[] args) {
		DatabaseHelper dbHelper=new DatabaseHelper();


		if (dbHelper.insertIntoCostumer("email", 100, "first", "last", 1)) {
			System.out.println("Inserted successfully");
		};

		System.out.println(dbHelper.selectCostumerEmail());
		System.out.println(dbHelper.selectRegistrationNumber());
		System.out.println(dbHelper.selectLocationId());
		System.out.println(dbHelper.selectCountAllFromBilling());
		

	
		
		
		dbHelper.close();
	}

}
