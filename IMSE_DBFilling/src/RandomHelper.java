import java.io.*;
import java.net.URL;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Random;

class RandomHelper {
    private final char[] alphabet = getCharSet();
    private Random rand;
    private ArrayList<String> firstNames;
    private ArrayList<String> lastNames;
    private ArrayList<String> email;
    private ArrayList<Integer> postcode;

    private static final String firstNameFile = "names.csv";
    private static final String lastNameFile = "surnames.csv";
    private static final String emails = "4000emails.csv";

    //instantiate the Random object and store data from files in lists
    RandomHelper() {
        this.rand = new Random();
        this.lastNames = readFile(lastNameFile);
        this.firstNames = readFile(firstNameFile);
        this.email = readFile(emails);
        this.postcode = new ArrayList<>(Arrays.asList(1010, 1020, 1030, 1040, 1050, 1060, 1070, 1080, 1090, 1100,
                1110, 1120, 1130, 1140, 1150, 1160, 1170,1180,1190,1200,1210,1220,1230,2333));
    }

    String getRandomString(int minLen, int maxLen) {
        StringBuilder out = new StringBuilder();
        int len = rand.nextInt((maxLen - minLen) + 1) + minLen;
        while (out.length() < len) {
            int idx = Math.abs((rand.nextInt() % alphabet.length));
            out.append(alphabet[idx]);
        }
        return out.toString();
    }

    String getRandomFirstName() {
        return firstNames.get(getRandomInteger(0, firstNames.size() - 1));
    }
    String getRandomLastName() {
        return lastNames.get(getRandomInteger(0, lastNames.size() - 1));
    }
    String getRandomEmail() { return email.get(getRandomInteger(0, email.size() - 1)); }
    Integer getRandomPostcode() {
        return postcode.get(getRandomInteger(0, postcode.size() - 1));
    }

    Double getRandomDouble(double min, double max, int precision) {
        double r = Math.pow(10, precision);
        return Math.round(min + (rand.nextDouble() * (max - min)) * r) / r;
    }

    Integer getRandomInteger(int min, int max) {
        return rand.nextInt((max - min) + 1) + min;
    }

    private ArrayList<String> readFile(String filename) {
        String line;
        ArrayList<String> set = new ArrayList<>();

        InputStream input = getClass().getClassLoader().getResourceAsStream(filename);

        try (BufferedReader br = new BufferedReader(new InputStreamReader(input))) {
            while ((line = br.readLine()) != null) {
                try {
                    set.add(line);
                } catch (Exception ignored) {
                }
            }

        } catch (Exception e) {
            e.printStackTrace();
        }
        return set;
    }

    private char[] getCharSet() {
        StringBuffer b = new StringBuffer(128);
        for (int i = 48; i <= 57; i++) b.append((char) i);        // 0-9
        for (int i = 65; i <= 90; i++) b.append((char) i);        // A-Z
        for (int i = 97; i <= 122; i++) b.append((char) i);       // a-z
        return b.toString().toCharArray();
    }
}