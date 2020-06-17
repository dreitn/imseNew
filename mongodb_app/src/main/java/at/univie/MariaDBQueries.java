package at.univie;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.logging.Logger;

public class MariaDBQueries {

    private Statement statement;
    private Connection connection;

    private static final Logger LOG = Logger.getLogger(MariaDBQueries.class.getName());

    public MariaDBQueries(Statement statement, Connection connection) {
        this.connection = connection;
        this.statement = statement;

        createViewsCostumerBillingLocations();

        LOG.info("Views created");

    }

    public void createViewsCostumerBillingLocations() {

        String createBillingView = "create View cosAndBill as\n" +
                "        select * from COSTUMER C natural join BILLING B where C.EMAIL = B.C_EMAIL";
        String createLocationView = "create View cosAndLoc as\n" +
                "        select * from COSTUMER C natural join LOCATIONS L where C.LOCATIONID = L.LOCATION_ID";

        try {
            Statement statement = connection.createStatement();

            statement.executeQuery(createBillingView);
            statement.executeQuery(createLocationView);

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public ResultSet querryOnEmailAdress(String email, Long locationID) {
        String querry = "SELECT * from cosAndBill A inner join cosAndLoc B on A.EMAIL=B.EMAIL\n" +
                "where A.EMAIL = '" + email + "' and A.LOCATIONID = '" + locationID + "';";

        ResultSet costumerSelection = null;

        try {
            Statement statement = connection.createStatement();
            costumerSelection = statement.executeQuery(querry);

        } catch (Exception e) {
            e.printStackTrace();
        }
        return costumerSelection;

    }

    public ResultSet getEmailByCostumerEmail(String email) {
        String querry = "Select * from BILLING b where b.C_EMAIL='" + email + "';\n";

        ResultSet billingsSelection = null;

        try {
            Statement statement = connection.createStatement();
            billingsSelection = statement.executeQuery(querry);

        } catch (Exception e) {
            e.printStackTrace();
        }
        return billingsSelection;

    }

    public ResultSet getLocationByLocationID(String locationId) {

        String querry = "Select * from LOCATIONS l where l.LOCATION_ID = '"+ locationId + "';\n";

        ResultSet locationSelection = null;

        try {
            Statement statement = connection.createStatement();
            locationSelection = statement.executeQuery(querry);

        } catch (Exception e) {
            e.printStackTrace();
        }
        return locationSelection;

    }

    public ResultSet getAreFriendsByCostumerEmail(String email) {
        String querry = "Select * from Costumer c where c.C_EMAIL='" + email + "';\n";

        ResultSet billingsSelection = null;

        try {
            Statement statement = connection.createStatement();
            billingsSelection = statement.executeQuery(querry);

        } catch (Exception e) {
            e.printStackTrace();
        }
        return billingsSelection;

    }

    public void dropViews() {

        String drop1 = "drop view cosAndLoc;\n";
        String drop2 = "drop view cosAndBill;\n";

        try {
            Statement statement = connection.createStatement();
            statement.execute(drop1);
            statement.execute(drop2);

        } catch (Exception e) {
            e.printStackTrace();
        }
        LOG.info("Views dropped");


    }
}
