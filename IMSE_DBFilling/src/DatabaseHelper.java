
import java.sql.*;
import java.time.LocalDate;
import java.util.ArrayList;


class DatabaseHelper {
    private static final String DB_CONNECTION_URL = "jdbc:mariadb://localhost:3306/db";
    private static final String USER = "user";
    private static final String PASS = "user";

    private static Statement stmt;
    private static Connection con;

    private int cos_count = 0;

    
    //CREATE CONNECTION
    DatabaseHelper() {
        try {
            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            stmt = con.createStatement();
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

    //INSERT INTO
    boolean insertIntoCostumer(String email, int phone_number, String firstname, String surname, int locId ) {

        try {
            String sql = "INSERT INTO COSTUMER (email, phone_number, firstname, surname, LOCATIONID) VALUES ('" +
            		 email +
                     "', '" +
                     phone_number +
                     "', '" +
                     firstname +
                     "', '" +
                    surname +
                    "', '" +
                    locId +
                    "')";
            stmt.execute(sql);
            cos_count++;
        } catch (Exception e) {
            return false;
        }
        return true;
    }

    void insertIntoLocation(int LocId, int zipcode, String street, String city) {
        try {
            String sql = "INSERT INTO LOCATIONS (LOCATION_ID, ZIP_CODE, STREET, CITY) VALUES ('" +
            		LocId +
                    "', '" +
                    zipcode +
                    "', '" +
                    street +
                    "', '" +
                    city +
                    "')";
            stmt.execute(sql);

        } catch (Exception e) {
            System.err.println("Error at: insertIntoLocations\nmessage: " + e.getMessage());
            cos_count--;
        }
    }

    void insertIntoCar(int regnr, String cmodel, int year, int price) {
        try {
            String sql = "INSERT INTO CAR (REGISTRATION_NUMBER, CAR_MODEL, MODEL_YEAR, DAILY_PRICE) VALUES ('" +
            		regnr +
                    "', '" +
                    cmodel +
                    "', '" +
                    year +
                    "', '" +
                    price +
                    "')";
            stmt.execute(sql);
        } catch (Exception e) {
            System.err.println("Error at: insertIntoCar\nmessage: " + e.getMessage());
        }
    }

    void insertIntoBilling(int nr, int total,  String date, String c_mail) {
        try {
            String sql = "INSERT INTO BILLING (BILL_NUMBER, TOTAL_PRICE, BILLDATE, C_EMAIL) VALUES ('" +
            		nr +
                    "', '" +
                    total +
                    "', '" +
                    date +
                    "', '" +
                    c_mail +
                    "')";
            stmt.execute(sql);
        } catch (Exception e) {
            System.err.println("Error at: insertIntoBilling\nmessage: " + e.getMessage());
        }
    }

    void insertIntoReservation(int nr,  String from, String returnd, int amount, int billnr) {
        try {
            String sql = "INSERT INTO RESERVATION (RESERVATION_NUMBER, FROM_DATE, RETURN_DATE, AMOUNT, RESERVATION_BILL_NUMBER) VALUES ('" +
            		nr +
                    "', '" +
                    from +
                    "', '" +
                    returnd +
                    "', '" +
                    amount +
                    "', '" +
                    billnr +
                    "')";
            stmt.execute(sql);
        } catch (Exception e) {
            System.err.println("Error at: insertIntoReservation\nmessage: " + e.getMessage());
        }
    }

    void insertIntoInsurance( int nr, String name) {
        try {
            String sql = "INSERT INTO INSURANCE (INSURANCE_NUMBER, NAME) VALUES ('" +
            	nr+
            	"', '" +
                    name +
                    "')";
            stmt.execute(sql);
        } catch (Exception e) {
            System.err.println("Error at: insertIntoInsurance\nmessage: " + e.getMessage());
        }
    }

    void insertIntoAreFriends( String email1, String email2) {
        try {
            String sql = "INSERT INTO ARE_FRIENDS (FRIEND_COSTUMER_EMAIL_1, FRIEND_COSTUMER_EMAIL_2) VALUES ('" +
                    email1+
                    "', '" +
                    email2 +
                    "')";
            stmt.execute(sql);
        } catch (Exception e) {
            System.err.println("Error at: insertIntoAreFriends\nmessage: " + e.getMessage());
        }
    }

    void insertIntoRent(String email1, int car, int reservation) {
        try {
            String sql = "INSERT INTO RENT(RENT_EMAIL, RENT_CAR, RENT_RESERVATION) VALUES ('" +
                    email1+
                    "', '" +
                    car +
                    "', '" +
                    reservation +
                    "')";
            stmt.execute(sql);
        } catch (Exception e) {
            System.err.println("Error at: insertIntoRent\nmessage: " + e.getMessage());
        }
    }

    //SELECT
    ArrayList<String> selectCostumerEmail() {
        ArrayList<String> emails = new ArrayList<>();

        try {
            ResultSet rs = stmt.executeQuery("SELECT EMAIL FROM COSTUMER ORDER BY EMAIL");
            while (rs.next()) {
                emails.add(rs.getString("EMAIL"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectCostumerEmail\n message: " + e.getMessage()).trim());
        }
        return emails;
    }

    ArrayList<String> selectRENTSize() {
        ArrayList<String> rents = new ArrayList<>();

        try {
            ResultSet rs = stmt.executeQuery("SELECT RENT_EMAIL FROM RENT");
            while (rs.next()) {
                rents.add(rs.getString("RENT_EMAIL"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectRENTSize\n message: " + e.getMessage()).trim());
        }
        return rents;
    }

    ArrayList<Integer> selectRegistrationNumber() {
        ArrayList<Integer> nr = new ArrayList<>();

        try {
            ResultSet rs = stmt.executeQuery("SELECT REGISTRATION_NUMBER FROM CAR");
            while (rs.next()) {
                nr.add(rs.getInt("REGISTRATION_NUMBER"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectRegistrationNumber\n message: " + e.getMessage()).trim());
        }
        return nr;
    }

    ArrayList<Integer> selectLocationId() {
        ArrayList<Integer> IDs = new ArrayList<>();

        try {
            ResultSet rs = stmt.executeQuery("SELECT LOCATION_ID FROM LOCATIONS");
            while (rs.next()) {
                IDs.add(rs.getInt("LOCATION_ID"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectLocationId\n message: " + e.getMessage()).trim());
        }
        return IDs;
    }

    int selectCountAllFromBilling(){
        int count = 0;
        try {
            ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM BILLING");
            while (rs.next()) {
                count = rs.getInt(1);
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectCountAllFromBilling\n message: " + e.getMessage()).trim());
        }
        return count;
    }

    public void close()  {
        try {
            stmt.close();
            con.close();
        } catch (Exception ignored) {
        }
    }
}
