import java.util.Scanner;
class Assig {

    static boolean isValidNumber(String lexeme) {
        int i = 0;
        int length = lexeme.length();

        boolean dotSeen = false;
        boolean digitSeen = false;
        boolean expSeen = false;
        boolean expSignSeen = false;
        boolean expDigitSeen = false;

        if (length == 0 || !(lexeme.charAt(0) >= '0' && lexeme.charAt(0) <= '9')) {
            return false;
        }

        while (i < length) {
            char ch = lexeme.charAt(i);

            switch (ch) {
                case '.':
                    if (dotSeen || expSeen) return false;
                    dotSeen = true;
                    i++;
                    if (i >= length || !(lexeme.charAt(i) >= '0' && lexeme.charAt(i) <= '9'))
                        return false;
                    break;

                case 'E':
                    if (expSeen || !digitSeen) return false;
                    expSeen = true;
                    i++;
                    if (i < length && (lexeme.charAt(i) == '+' || lexeme.charAt(i) == '-')) {
                        expSignSeen = true;
                        i++;
                    }
                    if (i >= length || !(lexeme.charAt(i) >= '0' && lexeme.charAt(i) <= '9'))
                        return false;
                    break;

                default:
                    if (lexeme.charAt(i) >= '0' && lexeme.charAt(i) <= '9') {
                        digitSeen = true;
                        if (expSeen) expDigitSeen = true;
                        i++;
                    } else {
                        return false;
                    }
                    break;
            }
        }

        if (expSeen && !expDigitSeen) return false;
        if (dotSeen && !digitSeen) return false;

        return true;
    }

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        System.out.println("Enter input:");
        String inputLine = sc.nextLine();

        System.out.println("LEXEME\tTOKEN NAME");
        System.out.println("------\t-----------");

        String lexeme = "";
        int dotCounter = 0;

        for (int i = 0; i < inputLine.length(); i++) {
            char ch = inputLine.charAt(i);

            if (ch == ' ') {
                if (lexeme.length() > 0) {
                    if (isValidNumber(lexeme))
                        System.out.println(lexeme + "\tnumber");
                    else
                        System.out.println(lexeme + "\tERROR: Unrecognized Lexeme");
                    lexeme = "";
                    dotCounter = 0;
                }
            } else if (ch == '.') {
                dotCounter++;
                if (dotCounter > 1) {
                    if (isValidNumber(lexeme))
                        System.out.println(lexeme + "\tnumber");
                    else
                        System.out.println(lexeme + "\tERROR: Unrecognized Lexeme");
                    lexeme = ".";
                    dotCounter = 1;
                } else {
                    lexeme += ch;
                }
            } else {
                lexeme += ch;
            }
        }

        if (lexeme.length() > 0) {
            if (isValidNumber(lexeme))
                System.out.println(lexeme + "\tnumber");
            else
                System.out.println(lexeme + "\tERROR: Unrecognized Lexeme");
        }

        sc.close();
    }
}
