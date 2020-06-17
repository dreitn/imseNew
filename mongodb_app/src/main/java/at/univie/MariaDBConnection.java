package at.univie;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.Statement;
import java.util.logging.Logger;


public class MariaDBConnection {
    private static final Logger LOG = Logger.getLogger(MariaDBConnection.class.getName());

    private static final String DB_CONNECTION_URL = "jdbc:mariadb://localhost:3306/db";
    private static final String USER = "user";
    private static final String PASS = "user";

    private static Statement stmt;
    private static Connection con;

    MariaDBConnection() {
        try {
            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            stmt = con.createStatement();
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
        LOG.info("Connected MariaDB successfully!!");

    }

    public static String getDbConnectionUrl() {
        return DB_CONNECTION_URL;
    }

    public static Statement getStmt() {
        return stmt;
    }

    public static Connection getCon() {
        return con;
    }
}
